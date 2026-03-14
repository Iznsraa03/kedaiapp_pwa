{{--
    Molecule: QrBottomSheet
    Menampilkan QR Code user dalam sebuah bottom sheet.
    Digunakan di halaman Home.
    Requires: simplesoftwareio/simple-qrcode, Alpine.js
--}}
@props(['user'])

<div
    x-data="{ open: false }"
    x-on:open-qr-sheet.window="open = true"
    class="relative z-50"
>
    {{-- Backdrop --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-on:click="open = false"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm"
        style="display: none;"
    ></div>

    {{-- Bottom Sheet --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-full"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-full"
        class="fixed bottom-0 lg:bottom-auto lg:top-1/2 left-1/2 -translate-x-1/2 lg:-translate-y-1/2 w-full max-w-md bg-white rounded-t-3xl lg:rounded-3xl shadow-2xl px-5 pt-4 pb-10 lg:pb-8 z-50"
        style="display: none;"
    >
        {{-- Drag Handle --}}
        <div class="flex justify-center mb-4">
            <div class="w-10 h-1.5 bg-gray-200 rounded-full"></div>
        </div>

        {{-- Header --}}
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-[#EFF6FF] rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z"/>
                    </svg>
                </div>
                <span class="text-[#1E3A8A] text-sm font-bold">QR Presensi Saya</span>
            </div>
            {{-- Close Button --}}
            <button
                x-on:click="open = false"
                class="w-8 h-8 bg-gray-100 rounded-xl flex items-center justify-center active:scale-90 transition-transform duration-150"
            >
                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- QR Code --}}
        <div class="flex flex-col items-center gap-4">
            <div class="p-4 bg-white border-2 border-[#EFF6FF] rounded-3xl shadow-sm">
                {!! QrCode::size(200)->color(37, 99, 235)->backgroundColor(239, 246, 255)->style('round')->eye('circle')->generate($user->nra) !!}
            </div>

            {{-- Identity --}}
            <div class="text-center">
                <p class="text-[#1E3A8A] font-extrabold text-lg leading-snug">{{ $user->name }}</p>
                <p class="text-[#2563EB] font-mono font-semibold text-base mt-0.5 tracking-widest">{{ $user->nra }}</p>
                <p class="text-gray-400 text-xs mt-1.5">Tunjukkan QR ini kepada admin untuk presensi</p>
            </div>

            {{-- Save/Print Button --}}
            <button
                onclick="window.print()"
                class="flex items-center gap-2 text-[#2563EB] text-xs font-semibold bg-[#EFF6FF] px-4 py-2.5 rounded-2xl active:opacity-60 transition-opacity"
            >
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                </svg>
                Simpan / Cetak QR
            </button>
        </div>
    </div>
</div>
