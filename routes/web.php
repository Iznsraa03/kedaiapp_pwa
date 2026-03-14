<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ActivityController as AdminActivityController;
use App\Models\News;

// Splash Screen
Route::get('/', function () {
    return view('splash');
})->name('splash');

// Auth Routes (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('throttle:5,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard Pages (Auth Required)
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        $activities = \App\Models\Activity::orderBy('starts_at')->paginate(10);
        $latestNews = News::orderBy('published_at', 'desc')->take(3)->get();
        return view('pages.home', compact('activities', 'latestNews'));
    })->name('home');

    Route::get('/kegiatan', function () {
        $status     = request('status', 'semua');
        $activities = \App\Models\Activity::withCount('attendances')
            ->when($status !== 'semua', fn ($q) => $q->where('status', $status))
            ->orderBy('starts_at')
            ->paginate(15);
        return view('pages.pesanan', compact('activities'));
    })->name('pesanan');

    Route::get('/direktori', function () {
        $members = \App\Models\User::where('role', 'member')->orderBy('name')->paginate(20);
        return view('pages.direktori', compact('members'));
    })->name('direktori');

    Route::get('/profil', function () {
        return view('pages.profil', ['user' => auth()->user()]);
    })->name('profil');

    Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/profil/edit', [ProfileController::class, 'update'])->name('profil.update');

    // News (User Frontend)
    Route::get('/berita', [\App\Http\Controllers\NewsController::class, 'index'])->name('news.index');

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
        Route::post('/kegiatan/{activity}/scan',  [AdminActivityController::class, 'scan'])->name('activities.scan')->middleware('throttle:30,1');

        Route::get('/kegiatan/{activity}/edit',    [AdminActivityController::class, 'edit'])->name('activities.edit');
        Route::put('/kegiatan/{activity}',        [AdminActivityController::class, 'update'])->name('activities.update');
        Route::delete('/kegiatan/{activity}',     [AdminActivityController::class, 'destroy'])->name('activities.destroy');

        // News Management
        Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
        Route::post('/news/fetch-data', [\App\Http\Controllers\Admin\NewsController::class, 'fetchNewsData'])->name('news.fetch-data')->middleware('throttle:10,1');
    });
});
