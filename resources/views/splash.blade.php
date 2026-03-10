<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#2563EB">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <title>KedaiApp</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#2563EB] font-sans">

    <div id="splash" class="max-w-md mx-auto min-h-screen bg-[#2563EB] flex flex-col items-center justify-center relative overflow-hidden">

        {{-- Background Decorations --}}
        <div class="absolute top-[-80px] right-[-80px] w-64 h-64 bg-white/10 rounded-full"></div>
        <div class="absolute bottom-[-60px] left-[-60px] w-48 h-48 bg-white/10 rounded-full"></div>
        <div class="absolute top-1/3 left-[-40px] w-32 h-32 bg-white/5 rounded-full"></div>

        {{-- Logo & Branding --}}
        <div class="flex flex-col items-center gap-6 animate-fade-in-up z-10">

            {{-- Logo --}}
            <div class="w-40 h-40 bg-white rounded-3xl flex items-center justify-center shadow-2xl p-3">
                <img src="/logo/KDCW.png" alt="KeDai Computerworks" class="w-full h-full object-contain drop-shadow-sm">
            </div>

            {{-- App Name --}}
            <div class="text-center">
                <h1 class="text-3xl font-extrabold text-white tracking-wide">KeDai Computerworks</h1>
                <p class="text-blue-200 text-sm mt-2 tracking-widest uppercase">Management System</p>
            </div>
        </div>

        {{-- Loading Indicator --}}
        <div class="absolute bottom-16 flex flex-col items-center gap-3 z-10">
            <div class="flex gap-2">
                <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 300ms"></div>
            </div>
            <p class="text-blue-200 text-xs">Memuat aplikasi...</p>
        </div>

    </div>

    <script>
        // Auto redirect setelah 3 detik
        setTimeout(function () {
            const splash = document.getElementById('splash');
            splash.classList.add('animate-fade-out');

            setTimeout(function () {
                @auth
                    window.location.href = '{{ route('home') }}';
                @else
                    window.location.href = '{{ route('login') }}';
                @endauth
            }, 500);
        }, 3000);
    </script>

</body>
</html>
