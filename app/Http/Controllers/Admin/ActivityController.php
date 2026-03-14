<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Attendance;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ActivityController extends Controller
{
    public function __construct(protected AttendanceService $attendanceService) {}

    /** Daftar semua kegiatan (admin) */
    public function index()
    {
        $activities = Activity::withCount('attendances')
            ->orderBy('starts_at')
            ->get();

        return view('pages.admin.activities.index', compact('activities'));
    }

    /** Form tambah kegiatan */
    public function create()
    {
        return view('pages.admin.activities.create');
    }

    /** Simpan kegiatan baru */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'location'    => 'nullable|string|max:255',
            'starts_at'   => 'required|date',
            'ends_at'     => 'required|date|after:starts_at',
            'status'      => 'required|in:upcoming,open,closed',
            'emoji'       => 'nullable|string|max:10',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // max 2MB
        ], [
            'starts_at.required' => 'Waktu mulai wajib diisi.',
            'ends_at.required'   => 'Waktu selesai wajib diisi.',
            'ends_at.after'      => 'Waktu selesai harus lebih lambat dari waktu mulai.',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('activities', 'public');
            $data['image'] = $path;
        }

        Activity::create($data);

        return redirect()->route('admin.activities.index')
            ->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    /** Halaman detail kegiatan untuk admin + scanner */
    public function show(Activity $activity)
    {
        $attendees = Attendance::with('user')
            ->where('activity_id', $activity->id)
            ->latest('scanned_at')
            ->get();

        return view('pages.admin.activities.show', compact('activity', 'attendees'));
    }

    /** API endpoint async: terima NRA atau Secure QR dari scanner, catat presensi */
    public function scan(Request $request, Activity $activity)
    {
        $request->validate(['nra' => 'required|string']);
        $input = $request->nra;

        // Cek apakah input adalah Secure QR (Base64 biasanya cukup panjang)
        // NRA biasanya hanya angka/huruf pendek.
        if (strlen($input) > 20) {
            $result = $this->attendanceService->recordBySecureQr(
                Auth::user(),
                $activity,
                $input
            );
        } else {
            $result = $this->attendanceService->recordByAdminScan(
                Auth::user(),
                $activity,
                $input
            );
        }

        if ($result['success']) {
            $latest = Attendance::with('user')
                ->where('activity_id', $activity->id)
                ->latest('scanned_at')
                ->first();

            $attendee = [
                'name'       => $latest->user->name,
                'nra'        => $latest->user->nra,
                'status'     => $latest->status,
                'scanned_at' => $latest->scanned_at->format('H:i:s'),
            ];

            $result['attendee'] = $attendee;

            // Simpan ke cache untuk SSE stream (expire 60 detik)
            $cacheKey = "activity_{$activity->id}_last_scan";
            Cache::put($cacheKey, [
                'attendee'  => $attendee,
                'timestamp' => now()->timestamp,
            ], 60);
        }

        return response()->json($result);
    }

    /** Halaman display fullscreen untuk layar besar */
    public function display(Activity $activity)
    {
        return view('pages.admin.activities.display', compact('activity'));
    }

    /** Polling endpoint — kembalikan data scan terbaru sebagai JSON */
    public function stream(Activity $activity)
    {
        $cacheKey = "activity_{$activity->id}_last_scan";
        $data     = Cache::get($cacheKey);

        return response()->json([
            'attendee'  => $data ? $data['attendee']  : null,
            'timestamp' => $data ? $data['timestamp'] : null,
            'total'     => $activity->attendances()->count(),
            'late'      => $activity->attendances()->where('status', 'late')->count(),
        ]);
    }
}
