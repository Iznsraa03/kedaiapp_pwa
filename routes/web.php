<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\ActivityController as AdminActivityController;

// Splash Screen
Route::get('/', function () {
    return view('splash');
})->name('splash');

// Auth Routes (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard Pages (Auth Required)
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        $activities = \App\Models\Activity::orderBy('starts_at')->get();
        return view('pages.home', compact('activities'));
    })->name('home');

    Route::get('/kegiatan', function () {
        $status     = request('status', 'semua');
        $activities = \App\Models\Activity::withCount('attendances')
            ->when($status !== 'semua', fn ($q) => $q->where('status', $status))
            ->orderBy('starts_at')
            ->get();
        return view('pages.pesanan', compact('activities'));
    })->name('pesanan');

    Route::get('/direktori', function () {
        $members = \App\Models\User::where('role', 'member')->orderBy('name')->get();
        return view('pages.direktori', compact('members'));
    })->name('direktori');

    Route::get('/profil', function () {
        return view('pages.profil', ['user' => auth()->user()]);
    })->name('profil');

    // Activities (User)
    Route::get('/kegiatan/{activity}', [ActivityController::class, 'show'])->name('activities.show');
    Route::post('/kegiatan/scan', [ActivityController::class, 'scan'])->name('activities.scan');

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/kegiatan',                   [AdminActivityController::class, 'index'])->name('activities.index');
        Route::get('/kegiatan/tambah',            [AdminActivityController::class, 'create'])->name('activities.create');
        Route::post('/kegiatan/tambah',           [AdminActivityController::class, 'store'])->name('activities.store');
        Route::get('/kegiatan/{activity}',         [AdminActivityController::class, 'show'])->name('activities.show');
        Route::get('/kegiatan/{activity}/display',[AdminActivityController::class, 'display'])->name('activities.display');
        Route::get('/kegiatan/{activity}/stream', [AdminActivityController::class, 'stream'])->name('activities.stream');
        Route::post('/kegiatan/{activity}/scan',  [AdminActivityController::class, 'scan'])->name('activities.scan');
    });
});
