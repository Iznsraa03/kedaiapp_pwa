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
     * Rekam presensi oleh Admin via scan NRA anggota (flow admin scanner).
     * $scanner = user admin yang melakukan scan.
     */
    public function recordByAdminScan(User $scanner, Activity $activity, string $nra): array
    {
        $member = User::where('nra', $nra)->first();

        if (! $member) {
            return ['success' => false, 'message' => "NRA {$nra} tidak ditemukan.", 'name' => null];
        }

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
     * Cek apakah user sudah hadir di suatu activity.
     */
    public function hasAttended(User $user, Activity $activity): bool
    {
        return Attendance::where('user_id', $user->id)
            ->where('activity_id', $activity->id)
            ->exists();
    }
}

