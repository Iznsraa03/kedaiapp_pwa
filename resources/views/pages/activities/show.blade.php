<x-app-layout>

    {{-- Header --}}
    <div class="bg-[#2563EB] px-5 pt-12 pb-8 relative overflow-hidden rounded-b-[2rem]">
        <div class="absolute -top-6 -right-6 w-36 h-36 rounded-full border-[24px] border-white/10 pointer-events-none"></div>
        <div class="absolute top-10 -right-2 w-16 h-16 rounded-full border-[10px] border-white/10 pointer-events-none"></div>

        {{-- Back --}}
        <a href="{{ route('home') }}"
           class="relative z-10 inline-flex items-center gap-1.5 text-white/70 hover:text-white text-sm font-semibold mb-4 active:opacity-60 transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>

        <div class="relative z-10 flex items-center gap-4">
            <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center text-3xl flex-shrink-0">
                {{ $activity->emoji }}
            </div>
            <div class="flex-1 min-w-0">
                <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[10px] font-semibold {{ $activity->badgeClass() }} mb-1">
                    {{ $activity->badgeLabel() }}
                </span>
                <h1 class="text-white text-lg font-extrabold leading-snug">{{ $activity->title }}</h1>
            </div>
        </div>
    </div>

    {{-- Body --}}
    <div class="px-5 py-5 space-y-4">

        {{-- Info Card --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm space-y-3">
            {{-- Tanggal & Waktu --}}
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 bg-[#EFF6FF] rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[#1E3A8A] text-sm font-semibold">{{ $activity->starts_at->translatedFormat('l, d F Y') }}</p>
                    <p class="text-gray-400 text-xs mt-0.5">
                        {{ $activity->starts_at->format('H.i') }} – {{ $activity->ends_at->format('H.i') }} WIB
                    </p>
                </div>
            </div>

            <div class="h-px bg-gray-50"></div>

            {{-- Lokasi --}}
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 bg-[#EFF6FF] rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[#1E3A8A] text-sm font-semibold">{{ $activity->location ?? 'Lokasi belum ditentukan' }}</p>
                    <p class="text-gray-400 text-xs mt-0.5">Lokasi Kegiatan</p>
                </div>
            </div>
        </div>

        {{-- Deskripsi --}}
        @if($activity->description)
        <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
            <h3 class="text-[#1E3A8A] text-sm font-bold mb-2">Tentang Kegiatan</h3>
            <p class="text-gray-500 text-sm leading-relaxed">{{ $activity->description }}</p>
        </div>
        @endif

        {{-- ===== QR PRESENSI USER ===== --}}
        @if($hasAttended)
            {{-- Sudah Hadir --}}
            <div class="bg-green-50 border border-green-100 rounded-2xl p-5 flex flex-col items-center gap-3">
                <div class="w-16 h-16 bg-white rounded-3xl flex items-center justify-center shadow-sm">
                    <svg class="w-8 h-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-center">
                    <p class="text-green-700 font-extrabold text-sm">Kehadiran Sudah Tercatat ✓</p>
                    <p class="text-green-600/70 text-xs mt-1">Kamu sudah berhasil melakukan presensi untuk kegiatan ini.</p>
                </div>
            </div>

        @elseif($activity->status === 'closed')
            {{-- Ditutup --}}
            <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5 flex flex-col items-center gap-3">
                <div class="w-16 h-16 bg-white rounded-3xl flex items-center justify-center shadow-sm">
                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
                <p class="text-gray-500 font-bold text-sm">Pendaftaran Ditutup</p>
            </div>

        @else
            {{-- Tampilkan QR Code NRA user untuk diperlihatkan ke admin --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-7 h-7 bg-[#EFF6FF] rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[#1E3A8A] font-bold text-sm">QR Presensi Kamu</p>
                        <p class="text-gray-400 text-xs">Tunjukkan ke admin untuk dicatat kehadiranmu</p>
                    </div>
                </div>
                <x-molecules.user-qr-card :user="auth()->user()" />
            </div>
        @endif

    </div>

</x-app-layout>
