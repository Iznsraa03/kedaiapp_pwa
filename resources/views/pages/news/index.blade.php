<x-app-layout>
    <div class="min-h-screen">
        <div class="px-5 pt-8 pb-4 relative overflow-hidden bg-[#1E3A8A] hd-wobbly-lg mt-2 mx-2">
            <a href="{{ route('home') }}" class="relative z-10 inline-flex items-center gap-1.5 text-white/70 hover:text-white text-sm font-semibold mb-5 active:opacity-60 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
            <h1 class="text-white text-2xl font-extrabold tracking-tight lg:text-3xl">Berita</h1>
            <p class="text-blue-200 text-sm mt-0.5">Semua update terbaru dari kami</p>
        </div>

        <div class="px-5 py-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                @forelse($news as $item)
                    <a href="#" class="bg-white hd-card overflow-hidden active:scale-[0.98] transition-all duration-150 flex flex-col">
                        @if($item->image_url)
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-40 object-cover">
                        @endif
                        <div class="p-4 flex-1">
                            <p class="text-[#1E3A8A] font-bold text-sm leading-snug">{{ $item->title }}</p>
                            <p class="text-gray-500 text-xs mt-1 line-clamp-2">{{ $item->short_description }}</p>
                            <div class="flex items-center gap-1 mt-2">
                                <svg class="w-3.5 h-3.5 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-gray-400 text-xs">
                                    {{ $item->published_at->translatedFormat('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full flex flex-col items-center gap-3 py-10 text-center">
                        <div class="w-16 h-16 bg-[#EFF6FF] rounded-3xl flex items-center justify-center text-3xl">📭</div>
                        <p class="text-[#1E3A8A] font-semibold text-sm">Belum ada berita</p>
                        <p class="text-gray-400 text-xs">Mohon kembali lagi nanti untuk update berita terbaru.</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-8">
                {{ $news->links() }}
            </div>
        </div>
    </div>
</x-app-layout>