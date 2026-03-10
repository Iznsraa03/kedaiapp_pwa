{{--
    Organism: QrScanner
    Kamera scanner untuk Admin. Logika JS sudah di-bundle via resources/js/app.js
    menggunakan Alpine.data('qrScannerOrg').
    Props:
      - activityId : ID kegiatan
      - scanUrl    : route API untuk submit scan
--}}
@props(['activityId', 'scanUrl'])

<div x-data="qrScannerOrg('{{ $scanUrl }}', '{{ $activityId }}')" class="space-y-4">

    {{-- ===== TOMBOL MULAI / STOP ===== --}}
    <button
        @click="toggleScanner()"
        :class="scanning
            ? 'bg-red-50 text-red-500 border border-red-100'
            : 'bg-[#2563EB] text-white shadow-lg shadow-blue-200'"
        class="w-full py-3.5 rounded-2xl font-bold text-sm flex items-center justify-center gap-2 transition-all duration-200 active:scale-[0.97]"
    >
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path x-show="!scanning" stroke-linecap="round" stroke-linejoin="round"
                d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
            <path x-show="!scanning" stroke-linecap="round" stroke-linejoin="round"
                d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
            <path x-show="scanning" stroke-linecap="round" stroke-linejoin="round"
                d="M6 18L18 6M6 6l12 12"/>
        </svg>
        <span x-text="scanning ? 'Hentikan Scanner' : 'Mulai Scan QR'"></span>
    </button>

    {{-- ===== VIEWPORT KAMERA — selalu di DOM, toggle via class ===== --}}
    <div :class="scanning ? 'block' : 'hidden'">
        <x-atoms.scanner-container id="qr-reader-admin" />
        <p class="text-center text-gray-400 text-xs mt-3">Arahkan kamera ke QR Code anggota</p>
    </div>

    {{-- ===== STATUS PROCESSING ===== --}}
    <div x-show="processing" x-cloak class="flex items-center justify-center gap-2 py-3">
        <svg class="animate-spin w-5 h-5 text-[#2563EB]" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
        </svg>
        <span class="text-[#2563EB] text-sm font-semibold">Memproses scan…</span>
    </div>

    {{-- ===== LAST SCAN RESULT ===== --}}
    <div x-show="lastResult" x-cloak
         :class="lastResult?.success ? 'bg-green-50 border-green-100' : 'bg-red-50 border-red-100'"
         class="border rounded-2xl px-4 py-3 flex items-start gap-3"
         x-transition>
        <div :class="lastResult?.success ? 'bg-green-100' : 'bg-red-100'"
             class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
            <svg class="w-4 h-4" :class="lastResult?.success ? 'text-green-600' : 'text-red-500'"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path x-show="lastResult?.success" stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                <path x-show="!lastResult?.success" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>
        <div>
            <p :class="lastResult?.success ? 'text-green-700' : 'text-red-600'"
               class="text-sm font-bold" x-text="lastResult?.name ?? ''"></p>
            <p class="text-xs text-gray-500 mt-0.5" x-text="lastResult?.message ?? ''"></p>
        </div>
    </div>

</div>
