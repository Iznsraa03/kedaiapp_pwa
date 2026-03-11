<x-app-layout>

    {{-- ===== APPBAR ===== --}}
    <div class="bg-[#2563EB] px-5 pt-12 pb-8 relative overflow-hidden rounded-b-[2rem]">
        {{-- Dekorasi --}}
        <div class="absolute -top-6 -right-6 w-36 h-36 rounded-full border-[24px] border-white/10 pointer-events-none"></div>
        <div class="absolute top-10 -right-2 w-16 h-16 rounded-full border-[10px] border-white/10 pointer-events-none"></div>

        {{-- Top Bar --}}
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-blue-200 text-xs font-medium">{{ now()->translatedFormat('l, d F Y') }}</p>
                <h1 class="text-white text-xl font-extrabold mt-1 leading-tight">KedaiApp</h1>
                <p class="text-blue-200 text-xs mt-0.5">Selamat datang kembali 👋</p>
            </div>
            {{-- Notif Bell --}}
            <button class="relative w-11 h-11 bg-white/15 rounded-2xl flex items-center justify-center active:scale-90 transition-transform duration-150">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="absolute top-2 right-2 w-2 h-2 bg-yellow-400 rounded-full"></span>
            </button>
        </div>
    </div>

    {{-- ===== PROFIL KAPSULE (terpisah, di luar appbar) ===== --}}
    <div class="px-5 mt-4 mb-1">
        <div class="flex items-center gap-2">
            {{-- Card Profil --}}
            <a href="{{ route('profil') }}"
               class="flex items-center gap-3 bg-white border border-gray-100 shadow-md active:scale-[0.98] hover:shadow-lg transition-all duration-150 flex-1 px-4 py-3"
               style="border-radius: 12px;">
                {{-- Avatar inisial --}}
                <div class="w-10 h-10 bg-[#EFF6FF] rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-[#2563EB] text-sm font-extrabold leading-none">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                </div>
                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <p class="text-[#1E3A8A] text-sm font-bold leading-none truncate">{{ Auth::user()->name }}</p>
                    <p class="text-gray-400 text-[11px] mt-0.5 font-medium">NRA: {{ Auth::user()->nra }}</p>
                </div>
                {{-- Badge Aktif + Arrow --}}
                <div class="flex items-center gap-2 flex-shrink-0">
                    <span class="bg-green-50 text-green-600 text-[10px] font-semibold px-2.5 py-1 rounded-full">● Aktif</span>
                    <svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            {{-- Tombol QR --}}
            <button
                onclick="window.dispatchEvent(new CustomEvent('open-qr-sheet'))"
                class="w-14 h-14 bg-[#2563EB] rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 active:scale-90 transition-transform duration-150 flex-shrink-0"
            >
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z"/>
                </svg>
            </button>
        </div>
    </div>

    @push('modals')
        <x-molecules.qr-bottomsheet :user="Auth::user()" />
    @endpush

    {{-- ===== CONTENT ===== --}}
    <div class="px-5 py-4 space-y-4">

        {{-- ===== KEGIATAN TERBARU ===== --}}
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-[#1E3A8A] font-bold text-base">Kegiatan Terbaru</h3>
                <span class="text-[#2563EB] text-xs font-semibold cursor-pointer active:opacity-60 transition-opacity">Lihat semua →</span>
            </div>

            @if($activities->isEmpty())
                <div class="flex flex-col items-center gap-3 py-10 text-center">
                    <div class="w-16 h-16 bg-[#EFF6FF] rounded-3xl flex items-center justify-center text-3xl">📭</div>
                    <p class="text-[#1E3A8A] font-semibold text-sm">Belum ada kegiatan</p>
                    <p class="text-gray-400 text-xs">Pantau terus untuk update kegiatan terbaru.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($activities as $activity)
                    <a href="{{ route('activities.show', $activity) }}"
                       class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm active:scale-[0.98] transition-transform duration-150 flex">
                        {{-- Stripe kiri --}}
                        <div class="w-1 {{ $activity->stripeClass() }} flex-shrink-0"></div>
                        {{-- Body --}}
                        <div class="flex-1 p-4">
                            <div class="flex items-start gap-3">
                                {{-- Emoji --}}
                                <div class="w-10 h-10 bg-[#EFF6FF] rounded-2xl flex items-center justify-center text-xl flex-shrink-0">
                                    {{ $activity->emoji }}
                                </div>
                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2">
                                        <p class="text-[#1E3A8A] font-bold text-sm leading-snug">{{ $activity->title }}</p>
                                        <span class="text-[10px] font-semibold px-2.5 py-1 rounded-xl flex-shrink-0 {{ $activity->badgeClass() }}">
                                            {{ $activity->badgeLabel() }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-1 mt-1.5">
                                        <svg class="w-3 h-3 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-gray-400 text-xs">
                                            {{ $activity->starts_at->translatedFormat('d M Y') }}
                                            · {{ $activity->starts_at->format('H.i') }}–{{ $activity->ends_at->format('H.i') }} WIB
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between mt-1">
                                        <div class="flex items-center gap-1">
                                            <svg class="w-3 h-3 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span class="text-gray-400 text-xs truncate">{{ $activity->location ?? 'Lokasi TBD' }}</span>
                                        </div>
                                        <span class="bg-[#2563EB] text-white text-[11px] font-semibold px-3 py-1.5 rounded-xl flex-shrink-0">
                                            Detail →
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</x-app-layout>
