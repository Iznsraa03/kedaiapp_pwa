<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#2563EB">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name', 'KedaiApp') }}">
    <link rel="manifest" href="/manifest.webmanifest">

    {{-- Apple Touch Icons (semua ukuran untuk iOS) --}}
    <link rel="apple-touch-icon" href="/icons/icon-180.png">
    <link rel="apple-touch-icon" sizes="57x57"   href="/icons/icon-57.png">
    <link rel="apple-touch-icon" sizes="60x60"   href="/icons/icon-60.png">
    <link rel="apple-touch-icon" sizes="72x72"   href="/icons/icon-72.png">
    <link rel="apple-touch-icon" sizes="76x76"   href="/icons/icon-76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/icons/icon-114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/icons/icon-120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/icons/icon-144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/icons/icon-152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="/icons/icon-167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/icons/icon-180.png">

    {{-- iOS Splash Screen Color --}}
    <meta name="msapplication-TileColor" content="#2563EB">
    <meta name="msapplication-TileImage" content="/icons/icon-144.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'KedaiApp') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-bg-soft font-sans antialiased">

    {{-- ===== SPLASH SCREEN OVERLAY ===== --}}
    <div id="splash-overlay" style="position:fixed;inset:0;z-index:9999;background:#2563EB;display:flex;flex-direction:column;align-items:center;justify-content:center;overflow:hidden;">

        {{-- Background Decorations --}}
        <div style="position:absolute;top:-80px;right:-80px;width:256px;height:256px;background:rgba(255,255,255,0.1);border-radius:9999px;"></div>
        <div style="position:absolute;bottom:-60px;left:-60px;width:192px;height:192px;background:rgba(255,255,255,0.1);border-radius:9999px;"></div>
        <div style="position:absolute;top:33%;left:-40px;width:128px;height:128px;background:rgba(255,255,255,0.05);border-radius:9999px;"></div>

        {{-- Logo & Branding --}}
        <div style="display:flex;flex-direction:column;align-items:center;gap:24px;position:relative;z-index:10;">
            <div style="width:160px;height:160px;background:white;border-radius:24px;display:flex;align-items:center;justify-content:center;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);padding:12px;">
                <img src="/logo/KDCW.png" alt="KeDai Computerworks" style="width:100%;height:100%;object-fit:contain;">
            </div>
            <div style="text-align:center;">
                <h1 style="font-size:1.875rem;font-weight:800;color:white;letter-spacing:0.05em;">KeDai Computerworks</h1>
                <p style="color:#bfdbfe;font-size:0.75rem;margin-top:8px;letter-spacing:0.2em;text-transform:uppercase;">Management System</p>
            </div>
        </div>

        {{-- Loading Indicator --}}
        <div style="position:absolute;bottom:64px;display:flex;flex-direction:column;align-items:center;gap:12px;z-index:10;">
            <div style="display:flex;gap:8px;">
                <div class="splash-dot" style="width:8px;height:8px;background:white;border-radius:9999px;animation:splashBounce 0.6s infinite alternate;animation-delay:0ms;"></div>
                <div class="splash-dot" style="width:8px;height:8px;background:white;border-radius:9999px;animation:splashBounce 0.6s infinite alternate;animation-delay:150ms;"></div>
                <div class="splash-dot" style="width:8px;height:8px;background:white;border-radius:9999px;animation:splashBounce 0.6s infinite alternate;animation-delay:300ms;"></div>
            </div>
            <p style="color:#bfdbfe;font-size:0.75rem;">Memuat aplikasi...</p>
        </div>

    </div>

    <style>
        @keyframes splashBounce {
            from { transform: translateY(0); }
            to   { transform: translateY(-8px); }
        }
    </style>

    <script>
        (function () {
            var splash = document.getElementById('splash-overlay');

            // Hanya tampilkan splash jika belum pernah tampil di sesi ini
            if (sessionStorage.getItem('splash_shown')) {
                // Langsung hapus tanpa animasi
                splash.remove();
            } else {
                // Tandai sudah tampil
                sessionStorage.setItem('splash_shown', '1');

                setTimeout(function () {
                    splash.style.transition = 'opacity 0.5s ease';
                    splash.style.opacity = '0';
                    setTimeout(function () {
                        splash.remove();
                    }, 500);
                }, 2000);
            }
        })();
    </script>

    <div id="page-content" class="max-w-md mx-auto min-h-screen bg-white relative flex flex-col shadow-xl">

    {{-- ===== iOS INSTALL GUIDE MODAL ===== --}}
    <div
        x-data="pwaInstall()"
        x-init="init()"
        x-cloak
    >
        {{-- Install Banner --}}
        <div
            x-show="showBanner"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-8"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-8"
            class="fixed bottom-20 left-1/2 -translate-x-1/2 z-[90] w-[calc(100%-2.5rem)] max-w-sm"
        >
            <div class="bg-white border border-blue-100 rounded-3xl shadow-xl shadow-blue-100/50 p-4 flex items-center gap-3">
                <div class="w-12 h-12 bg-white border border-gray-100 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg p-1">
                    <img src="/logo/KDCW.png" alt="KeDai Computerworks" class="w-full h-full object-contain">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[#1E3A8A] font-extrabold text-sm">Pasang KeDai Computerworks</p>
                    <p class="text-gray-400 text-xs mt-0.5 leading-snug">Tambah ke layar utama untuk akses lebih cepat!</p>
                </div>
                <div class="flex flex-col gap-1.5 flex-shrink-0">
                    <button @click="install()"
                        class="bg-[#2563EB] text-white text-xs font-bold px-4 py-2 rounded-xl active:scale-95 transition-all shadow-md shadow-blue-200">
                        Pasang
                    </button>
                    <button @click="dismiss()"
                        class="text-gray-400 text-xs font-medium px-4 py-1.5 rounded-xl hover:bg-gray-50 active:scale-95 transition-all text-center">
                        Nanti
                    </button>
                </div>
            </div>
        </div>

        {{-- iOS Guide Modal --}}
        <div
            x-show="showIosGuide"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[200] flex items-end justify-center"
            @click.self="showIosGuide = false"
        >
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

            {{-- Modal Sheet --}}
            <div
                x-show="showIosGuide"
                x-transition:enter="transition ease-out duration-400"
                x-transition:enter-start="opacity-0 translate-y-full"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-full"
                class="relative w-full max-w-md bg-white rounded-t-3xl px-6 pt-5 pb-10 shadow-2xl"
            >
                {{-- Handle --}}
                <div class="w-10 h-1 bg-gray-200 rounded-full mx-auto mb-5"></div>

                {{-- Header --}}
                <div class="flex items-center gap-3 mb-5">
                    <img src="/logo/KDCW.png" alt="KeDai Computerworks" class="w-12 h-12 object-contain rounded-2xl bg-white p-1 shadow-md border border-gray-100">
                    <div>
                        <p class="text-[#1E3A8A] font-extrabold text-base">Pasang ke Homescreen</p>
                        <p class="text-gray-400 text-xs mt-0.5">Ikuti langkah berikut di Safari</p>
                    </div>
                </div>

                {{-- Steps --}}
                <div class="space-y-4">

                    {{-- Step 1 --}}
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-[#2563EB] rounded-xl flex items-center justify-center flex-shrink-0 text-white font-extrabold text-sm">1</div>
                        <div class="flex-1 pt-1">
                            <p class="text-[#1E3A8A] font-semibold text-sm">Tap tombol <span class="text-[#2563EB]">Share</span></p>
                            <p class="text-gray-400 text-xs mt-0.5">Tombol Share berada di bagian bawah layar Safari</p>
                            <div class="mt-2 flex items-center gap-2 bg-[#EFF6FF] rounded-xl px-3 py-2">
                                <svg class="w-5 h-5 text-[#2563EB] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z"/>
                                </svg>
                                <span class="text-[#2563EB] text-xs font-semibold">Ikon kotak dengan panah ke atas ↑</span>
                            </div>
                        </div>
                    </div>

                    <div class="h-px bg-gray-50 ml-11"></div>

                    {{-- Step 2 --}}
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-[#2563EB] rounded-xl flex items-center justify-center flex-shrink-0 text-white font-extrabold text-sm">2</div>
                        <div class="flex-1 pt-1">
                            <p class="text-[#1E3A8A] font-semibold text-sm">Pilih <span class="text-[#2563EB]">"Add to Home Screen"</span></p>
                            <p class="text-gray-400 text-xs mt-0.5">Scroll ke bawah pada menu Share hingga menemukan opsi ini</p>
                            <div class="mt-2 flex items-center gap-2 bg-[#EFF6FF] rounded-xl px-3 py-2">
                                <svg class="w-5 h-5 text-[#2563EB] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span class="text-[#2563EB] text-xs font-semibold">Add to Home Screen</span>
                            </div>
                        </div>
                    </div>

                    <div class="h-px bg-gray-50 ml-11"></div>

                    {{-- Step 3 --}}
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-[#2563EB] rounded-xl flex items-center justify-center flex-shrink-0 text-white font-extrabold text-sm">3</div>
                        <div class="flex-1 pt-1">
                            <p class="text-[#1E3A8A] font-semibold text-sm">Tap <span class="text-[#2563EB]">"Add"</span> di pojok kanan atas</p>
                            <p class="text-gray-400 text-xs mt-0.5">Icon KedaiApp akan muncul di homescreen kamu</p>
                        </div>
                    </div>

                </div>

                {{-- Close Button --}}
                <button @click="showIosGuide = false"
                    class="mt-6 w-full py-3.5 bg-[#EFF6FF] text-[#2563EB] font-bold text-sm rounded-2xl active:scale-[0.97] transition-all">
                    Mengerti
                </button>

            </div>
        </div>
    </div>

    {{-- Flash Messages --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
                 x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed top-4 left-1/2 -translate-x-1/2 z-50 w-[calc(100%-2rem)] max-w-sm">
                <div class="flex items-center gap-3 bg-green-50 border border-green-100 rounded-2xl px-4 py-3 shadow-lg">
                    <div class="w-8 h-8 bg-green-100 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                    </div>
                    <p class="text-green-700 text-sm font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
                 x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed top-4 left-1/2 -translate-x-1/2 z-50 w-[calc(100%-2rem)] max-w-sm">
                <div class="flex items-center gap-3 bg-red-50 border border-red-100 rounded-2xl px-4 py-3 shadow-lg">
                    <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                    </div>
                    <p class="text-red-600 text-sm font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto pb-20 scrollbar-hide">
            {{ $slot }}
        </main>

        {{-- Bottom Navigation Bar (Organism) --}}
        <x-organisms.bottom-nav />
    </div>

    @stack('modals')
    @livewireScripts
    @stack('scripts')

    <script>
        function pwaInstall() {
            return {
                showBanner:    false,
                showIosGuide:  false,
                _deferredEvt:  null,
                _dismissed:    false,

                init() {
                    // Jangan tampilkan jika sudah di-install (standalone mode)
                    if (window.matchMedia('(display-mode: standalone)').matches
                        || window.navigator.standalone === true) {
                        return;
                    }

                    // Jangan tampilkan jika user pernah dismiss (simpan 7 hari)
                    const dismissed = localStorage.getItem('pwa_dismiss');
                    if (dismissed && Date.now() < parseInt(dismissed)) return;

                    // Tangkap event beforeinstallprompt (Chrome/Android)
                    window.addEventListener('beforeinstallprompt', (e) => {
                        e.preventDefault();
                        this._deferredEvt = e;
                        // Tampilkan banner setelah 2 detik
                        setTimeout(() => { this.showBanner = true; }, 2000);
                    });

                    // iOS Safari: tidak ada beforeinstallprompt, tampilkan manual
                    const isIos = /iphone|ipad|ipod/i.test(navigator.userAgent);
                    const isInStandalone = window.navigator.standalone;
                    if (isIos && !isInStandalone) {
                        const dismissed = localStorage.getItem('pwa_dismiss_ios');
                        if (!dismissed || Date.now() > parseInt(dismissed)) {
                            setTimeout(() => { this.showBanner = true; }, 2000);
                        }
                    }
                },

                async install() {
                    if (this._deferredEvt) {
                        // Android/Chrome — native prompt
                        this._deferredEvt.prompt();
                        const { outcome } = await this._deferredEvt.userChoice;
                        this._deferredEvt = null;
                        this.showBanner = false;
                        if (outcome === 'accepted') {
                            localStorage.removeItem('pwa_dismiss');
                        }
                    } else {
                        // iOS — tampilkan modal instruksi
                        this.showBanner = false;
                        this.showIosGuide = true;
                    }
                },

                dismiss() {
                    this.showBanner = false;
                    // Simpan dismiss selama 7 hari
                    const expire = Date.now() + 7 * 24 * 60 * 60 * 1000;
                    localStorage.setItem('pwa_dismiss', expire.toString());
                    localStorage.setItem('pwa_dismiss_ios', expire.toString());
                },
            }
        }
    </script>
</body>
</html>
