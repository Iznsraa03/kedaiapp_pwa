<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#2563EB">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>Daftar — KedaiApp</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .s1 { animation: slideUp .4s ease both; }
        .s2 { animation: slideUp .4s ease .06s both; }
        .s3 { animation: slideUp .4s ease .12s both; }
        .s4 { animation: slideUp .4s ease .18s both; }
        .s5 { animation: slideUp .4s ease .24s both; }
        .s6 { animation: slideUp .4s ease .30s both; }
        .s7 { animation: slideUp .4s ease .36s both; }
        .s8 { animation: slideUp .4s ease .42s both; }

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
        .field-input.error { border-color: #fca5a5; }
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
    <div class="s1 bg-[#2563EB] px-6 pt-12 pb-8 relative overflow-hidden rounded-b-[2.5rem]">
        <div class="absolute -top-8 -right-8 w-40 h-40 rounded-full border-[28px] border-white/10 pointer-events-none"></div>
        <div class="absolute bottom-0 -left-6 w-28 h-28 rounded-full border-[18px] border-white/10 pointer-events-none"></div>

        <a href="{{ route('login') }}" class="relative z-10 inline-flex items-center gap-1.5 text-white/70 hover:text-white text-sm font-semibold mb-5 active:opacity-60 transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>

        <div class="relative z-10 flex items-center gap-4">
            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0 p-1.5">
                <img src="/logo/KDCW.png" alt="KeDai Computerworks" class="w-full h-full object-contain">
            </div>
            <div>
                <h1 class="text-white text-2xl font-extrabold tracking-tight">Buat Akun Baru</h1>
                <p class="text-blue-200 text-sm mt-0.5">Lengkapi data diri kamu ✨</p>
            </div>
        </div>
    </div>

    {{-- FORM --}}
    <div class="flex-1 px-6 py-6 space-y-4">

        {{-- Error --}}
        @if ($errors->any())
        <div class="s2 flex items-start gap-3 bg-red-50 border border-red-100 rounded-2xl px-4 py-3">
            <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                </svg>
            </div>
            <div class="space-y-0.5">
                @foreach ($errors->all() as $error)
                    <p class="text-red-500 text-sm font-medium leading-snug">{{ $error }}</p>
                @endforeach
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data" class="space-y-3.5">
            @csrf

            {{-- Foto Profil --}}
            <div class="s2" x-data="{ preview: null }">
                <div class="flex flex-col items-center gap-3 py-2">
                    <div class="relative">
                        <div class="w-24 h-24 rounded-3xl bg-[#EFF6FF] border-2 border-dashed border-blue-200 flex items-center justify-center overflow-hidden">
                            <template x-if="!preview">
                                <div class="flex flex-col items-center gap-1">
                                    <svg class="w-7 h-7 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                    </svg>
                                    <span class="text-blue-300 text-[10px] font-medium">Foto</span>
                                </div>
                            </template>
                            <template x-if="preview">
                                <img :src="preview" class="w-full h-full object-cover">
                            </template>
                        </div>
                        <label for="avatar-register"
                            class="absolute -bottom-2 -right-2 w-8 h-8 bg-[#2563EB] rounded-xl flex items-center justify-center cursor-pointer shadow-md active:scale-90 transition-transform">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/>
                            </svg>
                        </label>
                    </div>
                    <input id="avatar-register" type="file" name="avatar" accept="image/*" class="hidden"
                        @change="preview = URL.createObjectURL($event.target.files[0])">
                    <p class="text-gray-400 text-xs text-center">Foto profil <span class="text-gray-300">(opsional, maks. 2MB)</span></p>
                    @error('avatar')
                        <p class="text-red-500 text-xs text-center">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Nama Lengkap --}}
            <div class="s2 space-y-1.5">
                <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Nama Lengkap</label>
                <div class="field-input {{ $errors->has('name') ? 'error' : '' }}">
                    <span class="icon">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                    </span>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap kamu" autocomplete="name">
                </div>
            </div>

            {{-- Email --}}
            <div class="s3 space-y-1.5">
                <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Email</label>
                <div class="field-input {{ $errors->has('email') ? 'error' : '' }}">
                    <span class="icon">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" autocomplete="email">
                </div>
            </div>

                                    {{-- NRA --}}
                                    <div class="s4 space-y-1.5">
                                        <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">NRA</label>
                                        <p class="text-gray-400 text-xs -mt-0.5">Format: <span class="font-mono text-[#2563EB]">000.KD.XXII.23</span></p>
                        
                                        {{-- Preview NRA --}}
                                        <div class="flex items-center gap-1.5 bg-[#EFF6FF] rounded-2xl px-4 py-2.5 border-2 {{ $errors->hasAny(['nra_seq','nra_roman','nra_year']) ? 'border-red-300' : 'border-transparent' }}">
                                            <svg class="w-4 h-4 text-[#2563EB] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/>
                                                </svg>
                                            <span class="font-mono text-[#1E3A8A] font-bold text-sm tracking-wider" id="nra-preview">___  .  KD  .  ___  .  __</span>
                                        </div>
                        
                                        {{-- Input Segments --}}
                                        <div class="grid grid-cols-[1fr_auto_1fr_auto_1fr] items-center gap-1.5">
                        
                                            {{-- Segmen 1: Nomor urut --}}
                                            <div>
                                                <input type="text" name="nra_seq" id="nra-seq"
                                                    value="{{ old('nra_seq') }}"
                                                    maxlength="5"
                                                    inputmode="numeric"
                                                    placeholder="001"
                                                    oninput="this.value=this.value.replace(/\D/g,''); updateNraPreview(); if(this.value.length>=3) document.getElementById('nra-roman').focus()"
                                                    class="w-full px-3 py-2.5 bg-white border-2 rounded-xl text-center font-mono text-[#1E3A8A] font-bold text-sm focus:outline-none focus:border-[#2563EB] transition-all {{ $errors->has('nra_seq') ? 'border-red-400' : 'border-gray-200' }}">
                                                <p class="text-gray-400 text-[10px] text-center mt-1">No. Urut</p>
                                            </div>
                        
                                            <span class="text-gray-400 font-bold text-lg text-center pb-4">.</span>
                        
                                            {{-- Segmen 2: KD (tetap) --}}
                                            <div class="bg-[#2563EB] rounded-xl px-2 py-2.5 text-center mb-4">
                                                <span class="font-mono text-white font-extrabold text-sm tracking-widest">KD</span>
                                            </div>
                        
                                            <span class="text-gray-400 font-bold text-lg text-center pb-4">.</span>
                        
                                            {{-- Segmen 3: Angka Romawi --}}
                                            <div>
                                                <input type="text" name="nra_roman" id="nra-roman"
                                                    value="{{ old('nra_roman') }}"
                                                    maxlength="10"
                                                    placeholder="XXII"
                                                    oninput="this.value=this.value.toUpperCase().replace(/[^IVXLCDM]/g,''); updateNraPreview()"
                                                    onkeyup="if(this.value.length>=1 && event.key==='.') document.getElementById('nra-year').focus()"
                                                    class="w-full px-3 py-2.5 bg-white border-2 rounded-xl text-center font-mono text-[#1E3A8A] font-bold text-sm focus:outline-none focus:border-[#2563EB] transition-all {{ $errors->has('nra_roman') ? 'border-red-400' : 'border-gray-200' }}">
                                                <p class="text-gray-400 text-[10px] text-center mt-1">Romawi</p>
                                            </div>
                                        </div>
                        
                                        {{-- Segmen 4: Tahun --}}
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="text-gray-400 font-bold text-lg">.</span>
                                            <div class="w-24">
                                                <input type="text" name="nra_year" id="nra-year"
                                                    value="{{ old('nra_year') }}"
                                                    maxlength="2"
                                                    inputmode="numeric"
                                                    placeholder="23"
                                                    oninput="this.value=this.value.replace(/\D/g,''); updateNraPreview()"
                                                    class="w-full px-3 py-2.5 bg-white border-2 rounded-xl text-center font-mono text-[#1E3A8A] font-bold text-sm focus:outline-none focus:border-[#2563EB] transition-all {{ $errors->has('nra_year') ? 'border-red-400' : 'border-gray-200' }}">
                                                <p class="text-gray-400 text-[10px] text-center mt-1">Tahun (2 digit)</p>
                                            </div>
                                            <p class="text-gray-400 text-xs">contoh: <span class="font-mono text-[#2563EB]">{{ date('y') }}</span></p>
                                        </div>
                        
                                        @if($errors->hasAny(['nra_seq','nra_roman','nra_year']))
                                            <div class="space-y-0.5">
                                                @foreach(['nra_seq','nra_roman','nra_year'] as $nraField)
                                                    @error($nraField)<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                        
                                    {{-- No. Telepon --}}
                                    <div class="s5 space-y-1.5">                            <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">No. Telepon <span class="text-gray-400 font-normal normal-case tracking-normal">(opsional)</span></label>
                            <div class="field-input {{ $errors->has('phone') ? 'error' : '' }}">
                                <span class="icon">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                                    </svg>
                                </span>
                                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" autocomplete="tel">
                            </div>
                        </div>
            
                        {{-- Password --}}
                        <div class="s5 space-y-1.5">                <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Password</label>
                <div class="field-input {{ $errors->has('password') ? 'error' : '' }}">
                    <span class="icon">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                    </span>
                    <input type="password" name="password" id="reg-pass" placeholder="Minimal 8 karakter" autocomplete="new-password">
                    <button type="button" class="eye-btn" onclick="togglePass('reg-pass','eye-1')">
                        <svg id="eye-1" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Konfirmasi Password --}}
            <div class="s7 space-y-1.5">
                <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Konfirmasi Password</label>
                <div class="field-input {{ $errors->has('password') ? 'error' : '' }}">
                    <span class="icon">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                        </svg>
                    </span>
                    <input type="password" name="password_confirmation" id="reg-confirm" placeholder="Ulangi password kamu" autocomplete="new-password">
                    <button type="button" class="eye-btn" onclick="togglePass('reg-confirm','eye-2')">
                        <svg id="eye-2" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Submit --}}
            <div class="s8 pt-2">
                <button type="submit"
                    class="w-full bg-[#2563EB] hover:bg-blue-700 active:scale-[0.97] text-white font-bold py-3.5 rounded-2xl shadow-lg shadow-blue-200 flex items-center justify-center gap-2 transition-all duration-200 group">
                    Daftar Sekarang
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </button>
            </div>

        </form>

        {{-- Login Link --}}
        <div class="s7 text-center pb-6">
            <p class="text-gray-400 text-sm">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-[#2563EB] font-bold hover:underline active:opacity-70 transition-all">
                    Masuk di sini
                </a>
            </p>
        </div>

    </div>
</div>



<script>
function updateNraPreview() {
    const seq   = document.getElementById('nra-seq')?.value.trim() || '';
    const roman = document.getElementById('nra-roman')?.value.trim() || '';
    const year  = document.getElementById('nra-year')?.value.trim() || '';

    const s1 = seq   ? seq.padStart(3, '0') : '___';
    const s3 = roman || '___';
    const s4 = year  || '__';

    document.getElementById('nra-preview').textContent =
        `${s1}  .  KD  .  ${s3}  .  ${s4}`;
}

// Init preview saat halaman load (jika ada old value)
document.addEventListener('DOMContentLoaded', updateNraPreview);

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
