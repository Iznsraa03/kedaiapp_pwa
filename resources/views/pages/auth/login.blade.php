<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#2563EB">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>Login — KedaiApp</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .s1 { animation: slideUp .4s ease both; }
        .s2 { animation: slideUp .4s ease .08s both; }
        .s3 { animation: slideUp .4s ease .16s both; }
        .s4 { animation: slideUp .4s ease .24s both; }
        .s5 { animation: slideUp .4s ease .32s both; }

        .field-input {
            display: flex;
            align-items: center;
            background: #EFF6FF;
            border: 2px solid transparent;
            border-radius: 1rem;
            transition: border-color .2s, box-shadow .2s;
            overflow: hidden;
        }
        .field-input:focus-within {
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37,99,235,.12);
        }
        .field-input.error {
            border-color: #fca5a5;
        }
        .field-input .icon {
            flex-shrink: 0;
            width: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #93c5fd;
        }
        .field-input input {
            flex: 1;
            height: 52px;
            background: transparent;
            border: none;
            outline: none;
            font-size: .875rem;
            font-weight: 500;
            color: #1E3A8A;
            padding-right: 1rem;
        }
        .field-input input::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }
        .field-input .eye-btn {
            flex-shrink: 0;
            width: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #93c5fd;
            cursor: pointer;
            background: none;
            border: none;
            transition: color .15s;
        }
        .field-input .eye-btn:hover { color: #2563EB; }
        .field-input .eye-btn:active { transform: scale(.9); }
    </style>
</head>
<body class="bg-[#EFF6FF] font-sans antialiased">

<div class="max-w-md mx-auto min-h-screen bg-white flex flex-col">

    {{-- HERO --}}
    <div class="s1 bg-[#2563EB] px-6 pt-16 pb-10 relative overflow-hidden rounded-b-[2.5rem]">
        <div class="absolute -top-8 -right-8 w-40 h-40 rounded-full border-[28px] border-white/10 pointer-events-none"></div>
        <div class="absolute bottom-0 -left-6 w-28 h-28 rounded-full border-[18px] border-white/10 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col items-center text-center gap-3">
            <div class="w-24 h-24 bg-white rounded-3xl flex items-center justify-center shadow-lg p-2">
                <img src="/logo/KDCW.png" alt="KeDai Computerworks" class="w-full h-full object-contain">
            </div>
            <div>
                <h1 class="text-white tracking-tight flex items-baseline justify-center">
                    <span class="font-rockwell text-2xl">KeDai</span>
                    <span class="font-staccato text-3xl ml-1">Computerworks</span>
                </h1>
                <p class="text-blue-200 text-sm mt-1">Selamat datang kembali 👋</p>
            </div>
        </div>
    </div>

    {{-- FORM --}}
    <div class="flex-1 px-6 py-8 space-y-6">

        {{-- Error --}}
        @if ($errors->any())
        <div class="s2 flex items-center gap-3 bg-red-50 border border-red-100 rounded-2xl px-4 py-3">
            <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                </svg>
            </div>
            <p class="text-red-500 text-sm font-medium">{{ $errors->first() }}</p>
        </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div class="s2 space-y-2">
                <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">
                    Email
                </label>
                <div class="field-input {{ $errors->has('email') ? 'error' : '' }}">
                    <span class="icon">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12A4.5 4.5 0 0112 16.5C9.695 16.5 7.747 15.006 7 12H3C3.753 15.006 5.695 16.5 8 16.5A4.5 4.5 0 0012 21C14.305 21 16.253 19.506 17 16.5H21C20.247 19.506 18.305 21 16 21A4.5 4.5 0 0112 16.5V12C12 9.695 10.506 7.747 7.5 7H3M12 3V7.5C12 9.695 10.506 11.747 7.5 12H3"/>
                        </svg>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email kamu" autocomplete="username">
                </div>
            </div>

            {{-- Password --}}
            <div class="s3 space-y-2">
                <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">
                    Password
                </label>
                <div class="field-input">
                    <span class="icon">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                    </span>
                    <input type="password" name="password" id="login-pass" placeholder="Masukkan password" autocomplete="current-password">
                    <button type="button" class="eye-btn" onclick="togglePass('login-pass','eye-login')">
                        <svg id="eye-login" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Submit --}}
            <div class="s4 pt-2">
                <button type="submit"
                    class="w-full bg-[#2563EB] hover:bg-blue-700 active:scale-[0.97] text-white font-bold py-3.5 rounded-2xl shadow-lg shadow-blue-200 flex items-center justify-center gap-2 transition-all duration-200 group">
                    Masuk
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </button>
            </div>
        </form>

        {{-- Divider --}}
        <div class="s4 flex items-center gap-3">
            <div class="flex-1 h-px bg-gray-100"></div>
            <span class="text-gray-300 text-xs font-semibold tracking-widest">ATAU</span>
            <div class="flex-1 h-px bg-gray-100"></div>
        </div>

        {{-- Register Link --}}
        <div class="s5 text-center pb-4">
            <p class="text-gray-400 text-sm">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-[#2563EB] font-bold hover:underline active:opacity-70 transition-all">
                    Daftar Sekarang
                </a>
            </p>
        </div>

    </div>
</div>

<script>
function togglePass(inputId, eyeId) {
    const input = document.getElementById(inputId);
    const eye   = document.getElementById(eyeId);
    const show  = input.type === 'password';
    input.type  = show ? 'text' : 'password';
    eye.innerHTML = show
        ? `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>`
        : `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>`;
}
</script>

</body>
</html>
