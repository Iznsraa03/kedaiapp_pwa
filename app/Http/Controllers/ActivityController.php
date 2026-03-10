<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function __construct(protected AttendanceService $attendanceService) {}

    public function show(Activity $activity)
    {
        $hasAttended = $this->attendanceService->hasAttended(Auth::user(), $activity);

        return view('pages.activities.show', compact('activity', 'hasAttended'));
    }

    public function scan(Request $request)
    {
        $request->validate([
            'uuid' => 'required|string',
        ]);

        $result = $this->attendanceService->recordByQr(Auth::user(), $request->uuid);

        if (! $result['success']) {
            return back()->with('error', $result['message']);
        }

        return redirect()
            ->route('activities.show', $result['activity'])
            ->with('success', $result['message']);
    }
}
