{{--
    Molecule: UserQrCard
    Menampilkan QR Code yang berisi NRA user, nama, dan NRA di bawahnya.
    Digunakan di halaman Profil.
    Requires: simplesoftwareio/simple-qrcode
--}}
@props(['user'])

<div class="bg-white border border-gray-100 rounded-3xl p-5 shadow-sm flex flex-col items-center gap-4">

    {{-- Header label --}}
    <div class="flex items-center gap-2">
        <div class="w-7 h-7 bg-[#EFF6FF] rounded-xl flex items-center justify-center">
            <svg class="w-4 h-4 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z"/>
            </svg>
        </div>
        <span class="text-[#1E3A8A] text-sm font-bold">QR Presensi Saya</span>
    </div>

    {{-- QR Code --}}
    <div class="p-3 bg-white border-2 border-[#EFF6FF] rounded-2xl shadow-sm">
        {!! QrCode::size(160)->color(37, 99, 235)->backgroundColor(239, 246, 255)->style('round')->eye('circle')->generate($user->nra) !!}
    </div>

    {{-- Identity --}}
    <div class="text-center">
        <p class="text-[#1E3A8A] font-extrabold text-base leading-snug">{{ $user->name }}</p>
        <p class="text-[#2563EB] font-mono font-semibold text-sm mt-0.5 tracking-widest">{{ $user->nra }}</p>
        <p class="text-gray-400 text-xs mt-1">Tunjukkan QR ini kepada admin untuk presensi</p>
    </div>

    {{-- Download hint --}}
    <button onclick="window.print()"
        class="flex items-center gap-1.5 text-[#2563EB] text-xs font-semibold active:opacity-60 transition-opacity">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
        </svg>
        Simpan / Cetak QR
    </button>

</div>
