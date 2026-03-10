<x-app-layout>

    {{-- Header --}}
    <div class="bg-[#2563EB] px-5 pt-12 pb-6 relative overflow-hidden rounded-b-[2rem]">
        <div class="absolute -top-6 -right-6 w-36 h-36 rounded-full border-[24px] border-white/10 pointer-events-none"></div>
        <div class="absolute top-10 -right-2 w-16 h-16 rounded-full border-[10px] border-white/10 pointer-events-none"></div>

        <div class="relative z-10">
            <h1 class="text-white text-xl font-extrabold">Kegiatan</h1>
            <p class="text-blue-200 text-sm mt-1">{{ $activities->count() }} kegiatan tersedia</p>
        </div>

        {{-- Tab Filter --}}
        <div class="relative z-10 flex gap-2 mt-4 overflow-x-auto pb-1 scrollbar-hide">
            @php
                $tabs = [
                    'semua'   => 'Semua',
                    'upcoming'=> 'Akan Datang',
                    'open'    => 'Buka Pendaftaran',
                    'closed'  => 'Ditutup',
                ];
                $active = request('status', 'semua');
            @endphp
            @foreach($tabs as $key => $label)
            <a href="{{ route('pesanan', $key !== 'semua' ? ['status' => $key] : []) }}"
               class="flex-shrink-0 px-4 py-2 rounded-2xl text-xs font-semibold transition-all duration-200
                   {{ $active === $key
                       ? 'bg-white text-[#2563EB] shadow-md'
                       : 'bg-white/20 text-white hover:bg-white/30' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- List Kegiatan --}}
    <div class="px-5 py-4 space-y-3">

        @forelse($activities as $activity)
        <a href="{{ route('activities.show', $activity) }}"
           class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm active:scale-[0.98] transition-transform duration-150 flex">

            {{-- Stripe kiri --}}
            <div class="w-1.5 {{ $activity->stripeClass() }} flex-shrink-0"></div>

            {{-- Body --}}
            <div class="flex-1 p-4">
                <div class="flex items-start gap-3">

                    {{-- Emoji --}}
                    <div class="w-12 h-12 bg-[#EFF6FF] rounded-2xl flex items-center justify-center text-2xl flex-shrink-0">
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

                        {{-- Tanggal --}}
                        <div class="flex items-center gap-1 mt-1.5">
                            <svg class="w-3 h-3 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-gray-400 text-xs">
                                {{ $activity->starts_at->translatedFormat('d M Y') }}
                                · {{ $activity->starts_at->format('H.i') }}–{{ $activity->ends_at->format('H.i') }} WIB
                            </span>
                        </div>

                        {{-- Lokasi & peserta --}}
                        <div class="flex items-center justify-between mt-1.5">
                            <div class="flex items-center gap-1 min-w-0">
                                <svg class="w-3 h-3 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="text-gray-400 text-xs truncate">{{ $activity->location ?? 'Lokasi TBD' }}</span>
                            </div>
                            <div class="flex items-center gap-1 flex-shrink-0 ml-2">
                                <svg class="w-3 h-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/>
                                </svg>
                                <span class="text-gray-400 text-xs">{{ $activity->attendances_count }} hadir</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @empty
        <div class="flex flex-col items-center gap-3 py-16 text-center">
            <div class="w-16 h-16 bg-[#EFF6FF] rounded-3xl flex items-center justify-center text-3xl">📭</div>
            <p class="text-[#1E3A8A] font-semibold text-sm">Belum ada kegiatan</p>
            <p class="text-gray-400 text-xs">Pantau terus untuk update kegiatan terbaru.</p>
        </div>
        @endforelse

    </div>

</x-app-layout>
