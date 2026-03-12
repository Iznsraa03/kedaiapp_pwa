<x-app-layout>

    {{-- Toast --}}
    <x-atoms.toast />

    {{-- Header --}}
    <div class="bg-[#1E3A8A] px-5 pt-12 pb-6 relative overflow-hidden rounded-b-[2rem]">
        <div class="absolute -top-6 -right-6 w-40 h-40 rounded-full border-[28px] border-white/10 pointer-events-none"></div>
        <div class="absolute top-12 -right-2 w-16 h-16 rounded-full border-[10px] border-white/10 pointer-events-none"></div>

        <div class="relative z-10 flex items-start justify-between">
            <div>
                {{-- Badge Admin --}}
                <div class="inline-flex items-center gap-1.5 bg-white/20 rounded-xl px-3 py-1.5 mb-3">
                    <div class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-white text-xs font-bold tracking-wide">MODE ADMIN</span>
                </div>
                <h1 class="text-white text-xl font-extrabold">Kelola Kegiatan</h1>
                <p class="text-blue-200 text-sm mt-1">{{ $activities->count() }} kegiatan terdaftar</p>
            </div>

            {{-- Tombol Tambah --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.news.create') }}"
                   class="flex-shrink-0 mt-1 flex items-center gap-2 bg-white text-[#1E3A8A] font-bold text-sm px-4 py-2.5 rounded-2xl shadow-lg active:scale-95 transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    News
                </a>
                <a href="{{ route('admin.activities.create') }}"
                   class="flex-shrink-0 mt-1 flex items-center gap-2 bg-white text-[#1E3A8A] font-bold text-sm px-4 py-2.5 rounded-2xl shadow-lg active:scale-95 transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Tambah
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="relative z-10 flex gap-3 mt-5">
            @php
                $counts = [
                    'open'    => $activities->where('status', 'open')->count(),
                    'upcoming'=> $activities->where('status', 'upcoming')->count(),
                    'closed'  => $activities->where('status', 'closed')->count(),
                ];
            @endphp
            <div class="flex-1 bg-white/10 rounded-2xl px-3 py-2.5 text-center">
                <p class="text-white font-extrabold text-xl">{{ $counts['open'] }}</p>
                <p class="text-green-300 text-[10px] mt-0.5 font-medium">Buka</p>
            </div>
            <div class="flex-1 bg-white/10 rounded-2xl px-3 py-2.5 text-center">
                <p class="text-white font-extrabold text-xl">{{ $counts['upcoming'] }}</p>
                <p class="text-blue-200 text-[10px] mt-0.5 font-medium">Akan Datang</p>
            </div>
            <div class="flex-1 bg-white/10 rounded-2xl px-3 py-2.5 text-center">
                <p class="text-white font-extrabold text-xl">{{ $counts['closed'] }}</p>
                <p class="text-gray-300 text-[10px] mt-0.5 font-medium">Ditutup</p>
            </div>
        </div>
    </div>

    {{-- List Kegiatan --}}
    <div class="px-5 py-4 space-y-3">

        @forelse($activities as $activity)
        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm flex">

            {{-- Stripe --}}
            <div class="w-1.5 {{ $activity->stripeClass() }} flex-shrink-0"></div>

            {{-- Body --}}
            <div class="flex-1 p-4">
                <div class="flex items-start gap-3">

                    {{-- Emoji --}}
                    <div class="w-11 h-11 bg-[#EFF6FF] rounded-2xl flex items-center justify-center text-2xl flex-shrink-0">
                        {{ $activity->emoji }}
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <p class="text-[#1E3A8A] font-bold text-sm leading-snug">{{ $activity->title }}</p>
                            <span class="text-[10px] font-semibold px-2 py-1 rounded-xl flex-shrink-0 {{ $activity->badgeClass() }}">
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

                        <div class="flex items-center justify-between mt-2">
                            {{-- Jumlah hadir --}}
                            <div class="flex items-center gap-1">
                                <svg class="w-3 h-3 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/>
                                </svg>
                                <span class="text-gray-400 text-xs">{{ $activity->attendances_count }} hadir</span>
                            </div>

                            {{-- Tombol Detail --}}
                            <a href="{{ route('admin.activities.show', $activity) }}"
                               class="flex items-center gap-1 bg-[#1E3A8A] text-white text-[11px] font-bold px-3 py-1.5 rounded-xl active:scale-95 transition-all duration-150">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/>
                                </svg>
                                Scan & Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="flex flex-col items-center gap-3 py-16 text-center">
            <div class="w-16 h-16 bg-[#EFF6FF] rounded-3xl flex items-center justify-center text-3xl">📭</div>
            <p class="text-[#1E3A8A] font-semibold text-sm">Belum ada kegiatan</p>
            <p class="text-gray-400 text-xs">Tambahkan kegiatan baru menggunakan tombol di atas.</p>
            <a href="{{ route('admin.activities.create') }}"
               class="mt-2 bg-[#2563EB] text-white font-bold text-sm px-6 py-3 rounded-2xl shadow-lg shadow-blue-200 active:scale-95 transition-all">
                + Tambah Kegiatan
            </a>
        </div>
        @endforelse

    </div>

</x-app-layout>
