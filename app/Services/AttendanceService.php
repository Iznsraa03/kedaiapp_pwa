<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    /**
     * Rekam presensi user via scan QR UUID activity (flow user mandiri).
     */
    public function recordByQr(User $user, string $activityUuid): array
    {
        $activity = Activity::where('uuid', $activityUuid)->first();

        if (! $activity) {
            return ['success' => false, 'message' => 'Kegiatan tidak ditemukan.'];
        }

        if ($activity->status === 'closed') {
            return ['success' => false, 'message' => 'Pendaftaran kegiatan sudah ditutup.'];
        }

        if ($this->hasAttended($user, $activity)) {
            return ['success' => false, 'message' => 'Kamu sudah tercatat hadir di kegiatan ini.'];
        }

        $now    = now();
        $isLate = $now->greaterThan($activity->starts_at->addMinutes(15));

        $attendance = DB::transaction(fn () => Attendance::create([
            'user_id'     => $user->id,
            'activity_id' => $activity->id,
            'scanned_at'  => $now,
            'status'      => $isLate ? 'late' : 'present',
        ]));

        return [
            'success'    => true,
            'message'    => $isLate ? 'Presensi berhasil — tercatat terlambat.' : 'Presensi berhasil dicatat!',
            'attendance' => $attendance,
            'activity'   => $activity,
        ];
    }

    /**
     * Rekam presensi oleh Admin via Secure QR Token (Flow: User show QR, Admin scan).
     */
    public function recordBySecureQr(User $scanner, Activity $activity, string $token): array
    {
        try {
            $decoded = base64_decode($token);
            if (! $decoded || ! str_contains($decoded, '|h:')) {
                return ['success' => false, 'message' => 'Format QR Code tidak valid.'];
            }

            [$data, $hashPart] = explode('|h:', $decoded);
            $expectedHash      = hash_hmac('sha256', $data, config('app.key'));

            if (! hash_equals($expectedHash, $hashPart)) {
                return ['success' => false, 'message' => 'QR Code palsu atau tidak valid.'];
            }

            // Parse data u:ID|a:ID|t:TIMESTAMP
            $parts = explode('|', $data);
            $userId     = (int) str_replace('u:', '', $parts[0]);
            $activityId = (int) str_replace('a:', '', $parts[1]);
            $timestamp  = (int) str_replace('t:', '', $parts[2]);

            // 1. Validasi Activity ID (Harus sesuai dengan scanner yang sedang aktif)
            if ($activityId !== $activity->id) {
                return ['success' => false, 'message' => 'QR ini bukan untuk kegiatan ini.'];
            }

            // 2. Validasi Expired (Misal: QR hanya berlaku 5 menit setelah digenerate)
            if (now()->timestamp - $timestamp > 300) {
                return ['success' => false, 'message' => 'QR Code sudah kedaluwarsa. Silakan refresh.'];
            }

            // 3. Ambil User
            $member = User::find($userId);
            if (! $member) {
                return ['success' => false, 'message' => 'User tidak ditemukan.'];
            }

            // 4. Proses Presensi (Reuse logic admin scan)
            return $this->processAttendance($scanner, $activity, $member);

        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan saat validasi QR.'];
        }
    }

    /**
     * Internal logic untuk mencatat presensi (Admin Scan & Secure QR).
     */
    protected function processAttendance(User $scanner, Activity $activity, User $member): array
    {
        if ($activity->status === 'closed') {
            return ['success' => false, 'message' => 'Kegiatan sudah ditutup.', 'name' => $member->name];
        }

        if ($this->hasAttended($member, $activity)) {
            return [
                'success' => false,
                'message' => "{$member->name} sudah tercatat hadir.",
                'name'    => $member->name,
            ];
        }

        $now    = now();
        $isLate = $now->greaterThan($activity->starts_at->addMinutes(15));

        DB::transaction(fn () => Attendance::create([
            'user_id'     => $member->id,
            'activity_id' => $activity->id,
            'scanned_by'  => $scanner->id,
            'scanned_at'  => $now,
            'status'      => $isLate ? 'late' : 'present',
        ]));

        return [
            'success' => true,
            'message' => $isLate
                ? "{$member->name} tercatat hadir (terlambat)."
                : "{$member->name} berhasil dipresensi!",
            'name'    => $member->name,
            'nra'     => $member->nra,
        ];
    }

    /**
     * Rekam presensi oleh Admin via scan NRA anggota (flow admin scanner).
     * $scanner = user admin yang melakukan scan.
     */
    public function recordByAdminScan(User $scanner, Activity $activity, string $nra): array
    {
        $member = User::where('nra', $nra)->first();

        if (! $member) {
            return ['success' => false, 'message' => "NRA {$nra} tidak ditemukan.", 'name' => null];
        }

        return $this->processAttendance($scanner, $activity, $member);
    }

    /**
     * Cek apakah user sudah hadir di suatu activity.
     */
    public function hasAttended(User $user, Activity $activity): bool
    {
        return Attendance::where('user_id', $user->id)
            ->where('activity_id', $activity->id)
            ->exists();
    }
}

