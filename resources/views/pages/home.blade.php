<x-app-layout>

    {{-- ===== APPBAR ===== --}}
    <div class="bg-[#2563EB] px-5 pt-12 pb-8 relative overflow-hidden rounded-b-[2rem]">
        {{-- Dekorasi --}}
        <div class="absolute -top-6 -right-6 w-36 h-36 rounded-full border-[24px] border-white/10 pointer-events-none">
        </div>
        <div class="absolute top-10 -right-2 w-16 h-16 rounded-full border-[10px] border-white/10 pointer-events-none">
        </div>

        {{-- Top Bar --}}
        <div class="relative z-10 flex items-center justify-center">
            <div class="flex items-center">
                <div class="w-9 h-9 bg-white rounded-xl flex items-center justify-center shrink-0">
                    <img src="/logo/KDCW.png" alt="Logo" class="w-8 h-8">
                </div>
                <div class="flex flex-col px-4">
                    <img src="/logo/KD.png" alt="KeDai Computerworks" class="h-6 w-auto">
                </div>
            </div>
        </div>
    </div>

    {{-- ===== CARD PROFIL ===== --}}
    <div class="px-5 mt-4 mb-1">
        <div class="bg-white border border-gray-100 shadow-md rounded-2xl overflow-hidden">

            {{-- Baris Atas: Avatar + Nama + Tombol QR --}}
            <div class="flex items-center gap-3 px-4 pt-4 pb-3">

                {{-- Avatar --}}
                <a href="{{ route('profil') }}" class="flex-shrink-0">
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}"
                            class="w-14 h-14 rounded-full object-cover border-2 border-[#EFF6FF]">
                    @else
                        <div
                            class="w-14 h-14 bg-[#EFF6FF] rounded-full flex items-center justify-center border-2 border-[#EFF6FF]">
                            <span class="text-[#2563EB] text-xl font-extrabold leading-none">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </div>
                    @endif
                </a>

                {{-- Nama + Badge Aktif --}}
                <div class="flex-1 min-w-0">
                    <p class="text-[#1E3A8A] text-base font-extrabold leading-tight truncate">{{ Auth::user()->name }}
                    </p>
                    <span
                        class="inline-flex items-center bg-green-50 text-green-600 text-[10px] font-semibold px-2 py-0.5 rounded-full mt-1">●
                        Aktif</span>
                </div>

            </div>

            {{-- Divider --}}
            <div class="mx-4 border-t border-gray-100"></div>

            {{-- Baris Bawah: NoReg & QR Button --}}
            <div class="flex items-center justify-between px-4 py-3 bg-[#F8FAFC]">

                {{-- NoReg --}}
                <div class="min-w-0">
                    <p class="text-gray-400 text-[10px] font-semibold uppercase tracking-wide">Nomor Registrasi</p>
                    <p class="text-[#1E3A8A] text-sm font-bold font-mono tracking-wider mt-0.5">
                        {{ Auth::user()->nra ?? '-' }}
                    </p>
                </div>

                {{-- Tombol QR (Subtle Style) --}}
                <button onclick="window.dispatchEvent(new CustomEvent('open-qr-sheet'))"
                    class="flex items-center gap-2 bg-white border border-blue-100 px-3 py-1.5 rounded-xl shadow-sm active:scale-95 transition-all duration-150">
                    <svg class="w-4 h-4 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
                    </svg>
                    <span class="text-[#1E3A8A] text-[11px] font-bold">Buka QR</span>
                </button>

            </div>

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
                <h3 class="text-navy font-bold text-base">Kegiatan Terbaru</h3>
            </div>

            @if($activities->isEmpty())
                <div class="flex flex-col items-center gap-3 py-10 text-center">
                    <div class="w-16 h-16 bg-bg-soft rounded-3xl flex items-center justify-center text-3xl">📭</div>
                    <p class="text-[#1E3A8A] font-semibold text-sm">Belum ada kegiatan</p>
                    <p class="text-gray-400 text-xs">Pantau terus untuk update kegiatan terbaru.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($activities as $activity)
                        <a href="{{ route('activities.show', $activity) }}"
                            class="block bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm active:scale-[0.98] transition-all duration-200">
                            
                            {{-- Thumbnail Section --}}
                            <div class="relative h-44 w-full bg-blue-50">
                                @if($activity->image)
                                    <img src="{{ $activity->image_url }}" alt="{{ $activity->title }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-5xl">
                                        {{ $activity->emoji ?? '📌' }}
                                    </div>
                                @endif

                                {{-- Status Badge Overlay --}}
                                <div class="absolute top-3 right-3">
                                    <span class="text-[10px] font-bold px-3 py-1.5 rounded-xl shadow-sm backdrop-blur-md {{ $activity->badgeClass() }} border border-white/20">
                                        {{ $activity->badgeLabel() }}
                                    </span>
                                </div>

                                {{-- Category/Stripe Indicator (Bottom Left) --}}
                                <div class="absolute bottom-0 left-0 w-full h-1 {{ $activity->stripeClass() }}"></div>
                            </div>

                            {{-- Content Section --}}
                            <div class="p-4">
                                {{-- Title --}}
                                <h4 class="text-[#1E3A8A] font-extrabold text-base leading-tight mb-2 line-clamp-2">
                                    {{ $activity->title }}
                                </h4>

                                {{-- Date & Time Info --}}
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="flex items-center gap-1.5 bg-[#EFF6FF] px-2.5 py-1.5 rounded-lg">
                                        <svg class="w-3.5 h-3.5 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-[#1E3A8A] text-[11px] font-bold">
                                            {{ $activity->starts_at->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-1.5 bg-gray-50 px-2.5 py-1.5 rounded-lg border border-gray-100">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-gray-500 text-[11px] font-semibold">
                                            {{ $activity->starts_at->format('H.i') }} - {{ $activity->ends_at->format('H.i') }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Divider --}}
                                <div class="h-px bg-gray-50 mb-3"></div>

                                {{-- Footer: Location & Detail --}}
                                <div class="grid grid-cols-[1fr_auto] items-center gap-3">
                                    <div class="flex items-center gap-1.5 min-w-0">
                                        <div class="w-7 h-7 bg-red-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-3.5 h-3.5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <span class="text-gray-500 text-[11px] font-medium truncate">
                                            {{ $activity->location ?? 'Lokasi TBD' }}
                                        </span>
                                    </div>

                                    <div class="bg-[#2563EB] text-white text-[11px] font-bold px-4 py-2 rounded-xl shadow-md shadow-blue-100 active:scale-95 transition-all">
                                        Detail →
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