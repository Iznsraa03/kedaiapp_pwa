<x-app-layout>
    <div class="max-w-md mx-auto min-h-screen bg-white flex flex-col">
        {{-- HEADER --}}
        <div class="bg-[#2563EB] px-5 pt-8 pb-4 relative overflow-hidden rounded-b-[2rem]">
            <h1 class="text-white text-2xl font-extrabold tracking-tight">News Management</h1>
            <p class="text-blue-200 text-sm mt-0.5">Kelola berita aplikasi anda</p>
        </div>

        <div class="flex-1 px-5 py-6 space-y-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-[#1E3A8A] font-bold text-lg">Daftar Berita</h3>
                <a href="{{ route('admin.news.create') }}" class="inline-flex items-center px-4 py-2 bg-[#2563EB] border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:scale-95 transition ease-in-out duration-150">
                    Add News
                </a>
            </div>

            @if ($news->isEmpty())
                <div class="flex flex-col items-center gap-3 py-10 text-center">
                    <div class="w-16 h-16 bg-[#EFF6FF] rounded-3xl flex items-center justify-center text-3xl">📭</div>
                    <p class="text-[#1E3A8A] font-semibold text-sm">Belum ada berita</p>
                    <p class="text-gray-400 text-xs">Tambahkan berita baru untuk ditampilkan di aplikasi.</p>
                </div>
            @else
                <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
                    <div class="p-4">
                        <ul class="divide-y divide-gray-100">
                            @foreach ($news as $item)
                                <li class="py-3">
                                    <div class="flex items-start gap-3">
                                        @if ($item->image_url)
                                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                                        @else
                                            <div class="w-16 h-16 bg-[#EFF6FF] rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-7 h-7 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[#1E3A8A] font-bold text-sm leading-snug">{{ $item->title }}</p>
                                            <p class="text-gray-500 text-xs mt-0.5 line-clamp-2">{{ $item->short_description }}</p>
                                            <p class="text-gray-400 text-[10px] mt-1">{{ $item->published_at->format('d M Y H:i') }}</p>
                                            <div class="flex items-center gap-2 mt-2">
                                                <a href="{{ route('admin.news.edit', $item) }}" class="text-[#2563EB] text-xs font-semibold hover:underline active:opacity-70 transition-all">Edit</a>
                                                <span class="text-gray-300 text-xs">|</span>
                                                <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this news item?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 text-xs font-semibold hover:underline active:opacity-70 transition-all">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="mt-4">
                    {{ $news->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>