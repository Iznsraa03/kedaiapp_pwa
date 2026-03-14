<x-app-layout>
    {{-- Toast --}}
    <x-atoms.toast />

    <div class="min-h-screen bg-gray-50 flex flex-col">
        {{-- Header --}}
        <div class="bg-[#1E3A8A] px-5 lg:px-8 pt-12 lg:pt-16 pb-7 lg:pb-10 relative overflow-hidden rounded-b-[2rem] lg:rounded-none">
            <div class="absolute -top-6 -right-6 w-40 h-40 rounded-full border-[28px] border-white/10 pointer-events-none"></div>
            <div class="absolute top-12 -right-2 w-16 h-16 rounded-full border-[10px] border-white/10 pointer-events-none"></div>

            <div class="max-w-7xl mx-auto w-full relative z-10">
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                    <div>
                        {{-- Badge Admin --}}
                        <div class="inline-flex items-center gap-1.5 bg-white/20 rounded-xl px-3 py-1.5 mb-3">
                            <div class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-white text-xs font-bold tracking-wide">MODE ADMIN</span>
                        </div>
                        <h1 class="text-white text-2xl lg:text-4xl font-extrabold tracking-tight">Kelola Kegiatan</h1>
                        <p class="text-blue-200 text-sm mt-1">Pantau dan kelola semua agenda kegiatan</p>
                    </div>

                    {{-- Actions & Stats --}}
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                        {{-- Stats Desktop --}}
                        <div class="hidden lg:flex gap-4 mr-4">
                            @php
                                $counts = [
                                    'open'    => $activities->where('status', 'open')->count(),
                                    'upcoming'=> $activities->where('status', 'upcoming')->count(),
                                    'closed'  => $activities->where('status', 'closed')->count(),
                                ];
                            @endphp
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl px-5 py-2 border border-white/10">
                                <p class="text-white font-extrabold text-lg leading-none">{{ $counts['open'] }}</p>
                                <p class="text-green-300 text-[10px] font-bold uppercase tracking-wider mt-1">Buka</p>
                            </div>
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl px-5 py-2 border border-white/10">
                                <p class="text-white font-extrabold text-lg leading-none">{{ $counts['upcoming'] }}</p>
                                <p class="text-blue-200 text-[10px] font-bold uppercase tracking-wider mt-1">Antri</p>
                            </div>
                        </div>

                        <a href="{{ route('admin.activities.create') }}"
                           class="flex items-center justify-center gap-2 bg-white text-[#1E3A8A] font-extrabold text-sm px-6 py-4 rounded-2xl shadow-xl hover:scale-[1.02] active:scale-95 transition-all duration-200 uppercase tracking-wide">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Tambah Kegiatan
                        </a>
                    </div>
                </div>

                {{-- Stats Mobile --}}
                <div class="lg:hidden flex gap-3 mt-8">
                    @foreach(['open' => ['bg-green-400', 'Buka'], 'upcoming' => ['bg-blue-300', 'Akan Datang'], 'closed' => ['bg-gray-400', 'Tutup']] as $st => $info)
                    <div class="flex-1 bg-white/10 rounded-2xl px-3 py-3 text-center border border-white/5">
                        <p class="text-white font-extrabold text-xl">{{ $activities->where('status', $st)->count() }}</p>
                        <p class="text-{{ explode('-', $info[0])[1] }}-300 text-[10px] mt-0.5 font-bold uppercase tracking-tighter">{{ $info[1] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="flex-1 px-5 lg:px-8 py-6 lg:py-10">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($activities as $activity)
                        <div class="group bg-white border border-gray-100 rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full">
                            {{-- Stripe Status --}}
                            <div class="h-2 {{ $activity->stripeClass() }}"></div>

                            <div class="p-6 lg:p-8 flex flex-col h-full">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-14 h-14 bg-[#EFF6FF] rounded-[1.5rem] flex items-center justify-center text-3xl shadow-inner group-hover:scale-110 transition-transform">
                                        {{ $activity->emoji }}
                                    </div>
                                    <span class="text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-widest shadow-sm {{ $activity->badgeClass() }}">
                                        {{ $activity->badgeLabel() }}
                                    </span>
                                </div>

                                <h3 class="text-[#1E3A8A] font-extrabold text-xl leading-tight mb-3 group-hover:text-[#2563EB] transition-colors">
                                    {{ $activity->title }}
                                </h3>

                                <div class="space-y-2 mb-6">
                                    <div class="flex items-center gap-2 text-gray-500">
                                        <svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span class="text-xs font-semibold truncate">{{ $activity->location ?: 'No Location' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-500">
                                        <svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-xs font-semibold">
                                            {{ $activity->starts_at->translatedFormat('d M Y, H:i') }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-500">
                                        <svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/>
                                        </svg>
                                        <span class="text-xs font-bold text-[#2563EB] bg-blue-50 px-2 py-0.5 rounded-lg">{{ $activity->attendances_count }} Partisipan</span>
                                    </div>
                                </div>

                                <div class="mt-auto pt-6 border-t border-gray-50 flex items-center gap-3">
                                    <a href="{{ route('admin.activities.show', $activity) }}"
                                       class="flex-1 flex items-center justify-center gap-2 bg-[#1E3A8A] text-white text-xs font-bold py-3.5 rounded-2xl shadow-lg shadow-blue-50 hover:bg-blue-700 active:scale-[0.97] transition-all">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5z"/>
                                        </svg>
                                        Detail & Scan
                                    </a>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.activities.edit', $activity) }}"
                                           title="Edit Kegiatan"
                                           class="w-12 h-12 flex items-center justify-center rounded-2xl border-2 border-gray-100 text-gray-400 hover:border-[#2563EB] hover:text-[#2563EB] hover:bg-blue-50 transition-all">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini? Semua data presensi terkait akan ikut terhapus.')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                title="Hapus Kegiatan"
                                                class="w-12 h-12 flex items-center justify-center rounded-2xl border-2 border-gray-100 text-gray-400 hover:border-red-500 hover:text-red-500 hover:bg-red-50 transition-all">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full flex flex-col items-center justify-center gap-4 py-20 text-center bg-white rounded-[2.5rem] border border-gray-100 shadow-sm">
                            <div class="w-24 h-24 bg-[#EFF6FF] rounded-[2rem] flex items-center justify-center text-5xl mb-2">📭</div>
                            <h3 class="text-[#1E3A8A] font-extrabold text-xl">Belum ada kegiatan</h3>
                            <p class="text-gray-400 text-sm max-w-xs mx-auto">Tambahkan kegiatan baru menggunakan tombol di atas.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
