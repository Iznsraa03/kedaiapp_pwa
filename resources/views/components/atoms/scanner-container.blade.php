{{--
    Atom: Scanner Container (QR Camera Viewport)
    Digunakan sebagai wrapper DOM untuk html5-qrcode library.
    Props: id (default: qr-reader)
--}}
@props(['id' => 'qr-reader'])

<div class="relative w-full aspect-square max-w-[280px] mx-auto">

    {{-- Camera viewport --}}
    <div
        id="{{ $id }}"
        class="w-full h-full rounded-3xl overflow-hidden bg-black"
    ></div>

    {{-- Corner frame overlay (bingkai biru) --}}
    <div class="absolute inset-0 pointer-events-none rounded-3xl">
        {{-- Top-left --}}
        <div class="absolute top-3 left-3 w-8 h-8 border-t-4 border-l-4 border-[#2563EB] rounded-tl-2xl"></div>
        {{-- Top-right --}}
        <div class="absolute top-3 right-3 w-8 h-8 border-t-4 border-r-4 border-[#2563EB] rounded-tr-2xl"></div>
        {{-- Bottom-left --}}
        <div class="absolute bottom-3 left-3 w-8 h-8 border-b-4 border-l-4 border-[#2563EB] rounded-bl-2xl"></div>
        {{-- Bottom-right --}}
        <div class="absolute bottom-3 right-3 w-8 h-8 border-b-4 border-r-4 border-[#2563EB] rounded-br-2xl"></div>
    </div>

    {{-- Scan line animation (hanya saat kamera aktif) --}}
    <div
        class="absolute inset-x-6 h-0.5 bg-gradient-to-r from-transparent via-[#2563EB] to-transparent rounded-full pointer-events-none"
        style="animation: scanLine 2s ease-in-out infinite; top: 1.5rem;"
    ></div>

</div>
