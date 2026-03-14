<x-app-layout>
    <div class="min-h-screen bg-gray-50 flex flex-col">
        {{-- HEADER --}}
        <div class="bg-[#1E3A8A] px-5 lg:px-8 pt-12 lg:pt-16 pb-7 lg:pb-10 relative overflow-hidden rounded-b-[2rem] lg:rounded-none">
            <div class="absolute -top-6 -right-6 w-36 h-36 rounded-full border-[24px] border-white/10 pointer-events-none"></div>
            
            <div class="max-w-7xl mx-auto w-full relative z-10">
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 bg-white/20 rounded-xl px-3 py-1.5 mb-3">
                            <div class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-white text-xs font-bold tracking-wide">MODE ADMIN</span>
                        </div>
                        <h1 class="text-white text-2xl lg:text-4xl font-extrabold tracking-tight">News Management</h1>
                        <p class="text-blue-200 text-sm mt-1">Kelola berita aplikasi anda</p>
                    </div>

                    <a href="{{ route('admin.news.create') }}"
                       class="flex items-center gap-2 bg-white text-[#1E3A8A] font-extrabold text-sm px-6 py-4 rounded-2xl shadow-xl hover:scale-[1.02] active:scale-95 transition-all duration-200 uppercase tracking-wide">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Tambah Berita
                    </a>
                </div>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="flex-1 px-5 lg:px-8 py-6 lg:py-10">
            <div class="max-w-7xl mx-auto">
                @if ($news->isEmpty())
                    <div class="flex flex-col items-center justify-center gap-4 py-20 text-center bg-white rounded-[2.5rem] border border-gray-100 shadow-sm">
                        <div class="w-24 h-24 bg-[#EFF6FF] rounded-[2rem] flex items-center justify-center text-5xl mb-2">📭</div>
                        <h3 class="text-[#1E3A8A] font-extrabold text-xl">Belum ada berita</h3>
                        <p class="text-gray-400 text-sm max-w-xs mx-auto">Tambahkan berita baru untuk ditampilkan di aplikasi.</p>
                        <a href="{{ route('admin.news.create') }}" class="mt-2 text-[#2563EB] font-bold text-sm hover:underline">Mulai buat berita pertama &rarr;</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($news as $item)
                            <div class="group bg-white border border-gray-100 rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                                {{-- Thumbnail --}}
                                <div class="relative h-48 overflow-hidden bg-gray-100">
                                    @if ($item->image_url)
                                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-12 h-12 text-blue-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-[10px] font-bold text-[#1E3A8A] uppercase tracking-widest shadow-sm">
                                            {{ $item->published_at->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Body --}}
                                <div class="p-6 flex-1 flex flex-col">
                                    <h3 class="text-[#1E3A8A] font-extrabold text-lg leading-tight line-clamp-2 mb-2 group-hover:text-[#2563EB] transition-colors">
                                        {{ $item->title }}
                                    </h3>
                                    <p class="text-gray-500 text-sm line-clamp-2 mb-6 flex-1">
                                        {{ $item->short_description }}
                                    </p>

                                    {{-- Actions --}}
                                    <div class="flex items-center justify-between pt-5 border-t border-gray-50">
                                        <div class="flex items-center gap-4">
                                            <a href="{{ route('admin.news.edit', $item) }}" class="text-[#2563EB] text-xs font-bold flex items-center gap-1.5 hover:underline">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this news item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 text-xs font-bold flex items-center gap-1.5 hover:text-red-600 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                        <div class="text-gray-300">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-12">
                        {{ $news->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>