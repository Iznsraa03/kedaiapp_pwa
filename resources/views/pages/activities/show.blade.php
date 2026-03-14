<x-app-layout>

    {{-- Header --}}
    <div class="bg-[#2563EB] px-5 pt-12 pb-16 relative overflow-hidden rounded-b-[2.5rem]">
        <div class="absolute -top-6 -right-6 w-36 h-36 rounded-full border-[24px] border-white/10 pointer-events-none"></div>
        
        <div class="relative z-10 flex items-center justify-between mb-4">
            <a href="{{ route('home') }}" class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-white active:scale-90 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
        </div>
    </div>

    {{-- Main Body --}}
    <div class="px-5 -mt-8 space-y-5 pb-12">
        
        {{-- Thumbnail Card --}}
        <div class="bg-white p-2 rounded-[2rem] shadow-xl shadow-blue-900/5 relative">
            <div class="relative h-52 w-full overflow-hidden rounded-[1.75rem] bg-gray-50">
                @if($activity->image)
                    <img src="{{ $activity->image_url }}" alt="{{ $activity->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-6xl">
                        {{ $activity->emoji ?? '📌' }}
                    </div>
                @endif

                {{-- Status Tag --}}
                <div class="absolute top-3 left-3">
                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider shadow-lg {{ $activity->badgeClass() }} border border-white/20">
                        {{ $activity->badgeLabel() }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Title Section --}}
        <div class="px-1">
            <h1 class="text-[#1E3A8A] text-2xl font-black leading-tight">{{ $activity->title }}</h1>
        </div>

        {{-- Info Grid --}}
        <div class="bg-white border border-gray-100 rounded-[2rem] p-5 shadow-sm space-y-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[#1E3A8A] text-sm font-black">{{ $activity->starts_at->translatedFormat('l, d F Y') }}</p>
                    <p class="text-gray-400 text-xs mt-0.5 font-medium uppercase tracking-wide">
                        {{ $activity->starts_at->format('H:i') }} – {{ $activity->ends_at->format('H:i') }} WIB
                    </p>
                </div>
            </div>

            <div class="h-px bg-gray-50 mx-2"></div>

            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[#1E3A8A] text-sm font-black truncate">{{ $activity->location ?? 'Lokasi belum ditentukan' }}</p>
                    <p class="text-gray-400 text-xs mt-0.5 font-medium uppercase tracking-wide">Lokasi Kegiatan</p>
                </div>
            </div>
        </div>

        {{-- About Section --}}
        @if($activity->description)
        <div class="space-y-3 px-1">
            <h3 class="text-[#1E3A8A] font-black text-sm uppercase tracking-widest flex items-center gap-2">
                <span class="w-1 h-4 bg-[#2563EB] rounded-full"></span>
                Deskripsi
            </h3>
            <p class="text-gray-500 text-sm leading-relaxed">{{ $activity->description }}</p>
        </div>
        @endif

        {{-- QR Presensi Section --}}
        <div class="pt-2">
            @if($hasAttended)
                <div class="bg-green-50 border border-green-100 rounded-[2rem] p-8 text-center animate-fade-in-up">
                    <div class="w-20 h-20 bg-white rounded-[1.75rem] flex items-center justify-center mx-auto mb-4 shadow-lg border-4 border-white">
                        <svg class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-green-700 font-black text-lg">Hadir!</h4>
                    <p class="text-green-600/70 text-xs font-bold mt-1">Presensi kamu sudah tercatat.</p>
                </div>
            @elseif($activity->status === 'closed')
                <div class="bg-gray-50 border border-gray-100 rounded-[2rem] p-8 text-center opacity-70">
                    <p class="text-gray-400 font-black text-xs uppercase tracking-[0.2em]">Presensi Telah Ditutup</p>
                </div>
            @else
                <div x-data="{ showQr: false, loading: false }">
                    {{-- Action Button --}}
                    <div x-show="!showQr" class="bg-white border-2 border-dashed border-blue-100 rounded-[2rem] p-8 text-center space-y-4">
                        <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto text-blue-600">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                            </svg>
                        </div>
                        <p class="text-gray-400 text-xs font-medium px-4 leading-relaxed">Ketuk tombol di bawah untuk menampilkan QR kehadiran anda di lokasi.</p>
                        <button @click="loading = true; setTimeout(() => { showQr = true; loading = false }, 800)"
                            class="w-full bg-[#2563EB] text-white font-black py-4 rounded-2xl shadow-lg shadow-blue-200 active:scale-95 transition-all flex items-center justify-center gap-3">
                            <template x-if="!loading">
                                <span class="text-xs uppercase tracking-widest">Generate QR Presensi</span>
                            </template>
                            <template x-if="loading">
                                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </template>
                        </button>
                    </div>

                    {{-- QR Display (Modern Digital Pass Style) --}}
                    <div x-show="showQr" 
                        x-transition:enter="transition cubic-bezier(0.34, 1.56, 0.64, 1) duration-500" 
                        x-transition:enter-start="opacity-0 scale-95 translate-y-10"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        class="bg-white rounded-[3rem] shadow-2xl shadow-blue-900/10 border border-gray-100 overflow-hidden relative"
                    >
                        {{-- Pass Header --}}
                        <div class="bg-[#1E3A8A] px-6 py-5 text-center relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-full -mr-10 -mt-10"></div>
                            <div class="relative z-10">
                                <h4 class="text-white font-black text-sm uppercase tracking-[0.2em]">Presensi Digital</h4>
                                <p class="text-blue-200 text-[10px] font-bold mt-0.5 opacity-80">TOKEN KEHADIRAN AKTIF</p>
                            </div>
                        </div>

                        {{-- Pass Body (QR Area) --}}
                        <div class="p-8 flex flex-col items-center">
                            {{-- QR Frame --}}
                            <div class="relative p-2 bg-gradient-to-tr from-gray-50 to-white rounded-[2.5rem] shadow-inner border border-gray-100 mb-6 group">
                                <div class="bg-white p-5 rounded-[2rem] shadow-xl relative z-10">
                                    {!! QrCode::size(170)->margin(0)->color(30, 58, 138)->generate(auth()->user()->generateAttendanceToken($activity)) !!}
                                </div>
                                {{-- Corner Decorations --}}
                                <div class="absolute -top-1 -left-1 w-6 h-6 border-t-4 border-l-4 border-[#2563EB] rounded-tl-xl opacity-40"></div>
                                <div class="absolute -bottom-1 -right-1 w-6 h-6 border-b-4 border-r-4 border-[#2563EB] rounded-br-xl opacity-40"></div>
                            </div>

                            {{-- Status & Timer --}}
                            <div class="flex flex-col items-center gap-3 w-full">
                                <div class="inline-flex items-center gap-2 bg-green-50 px-4 py-2 rounded-2xl border border-green-100">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                    </span>
                                    <span class="text-green-600 text-[10px] font-black uppercase tracking-widest">Valid 5 Menit</span>
                                </div>
                                <p class="text-gray-400 text-[10px] font-medium max-w-[220px] leading-relaxed text-center">
                                    Perlihatkan QR ini ke panitia. Token akan otomatis kedaluwarsa demi keamanan.
                                </p>
                            </div>
                        </div>

                        {{-- Perforated Line (Dashed) --}}
                        <div class="flex items-center px-4">
                            <div class="w-6 h-6 bg-gray-50 rounded-full -ml-7 border-r border-gray-100"></div>
                            <div class="flex-1 border-t-2 border-dashed border-gray-100"></div>
                            <div class="w-6 h-6 bg-gray-50 rounded-full -mr-7 border-l border-gray-100"></div>
                        </div>

                        {{-- Pass Footer --}}
                        <div class="p-4 bg-gray-50/50">
                            <button @click="showQr = false" class="w-full py-3 text-gray-400 text-[10px] font-black uppercase tracking-[0.2em] hover:text-[#1E3A8A] transition-colors">
                                Sembunyikan QR
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

</x-app-layout>
