<x-app-layout>
    <div class="max-w-md mx-auto min-h-screen bg-white flex flex-col">
        {{-- HEADER --}}
        <div class="bg-[#2563EB] px-5 pt-8 pb-4 relative overflow-hidden rounded-b-[2rem]">
            <a href="{{ route('admin.news.index') }}" class="relative z-10 inline-flex items-center gap-1.5 text-white/70 hover:text-white text-sm font-semibold mb-5 active:opacity-60 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
            <h1 class="text-white text-2xl font-extrabold tracking-tight">Edit News</h1>
            <p class="text-blue-200 text-sm mt-0.5">Edit berita yang sudah ada</p>
        </div>

        <div class="flex-1 px-5 py-6 space-y-4">
            <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm p-6">
                <form method="POST" action="{{ route('admin.news.update', $news) }}">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-[#1E3A8A] text-sm font-medium mb-1">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-[#1E3A8A]">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="mb-4">
                        <label for="slug" class="block text-[#1E3A8A] text-sm font-medium mb-1">Slug</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $news->slug) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-[#1E3A8A]">
                        @error('slug')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Short Description -->
                    <div class="mb-4">
                        <label for="short_description" class="block text-[#1E3A8A] text-sm font-medium mb-1">Short Description</label>
                        <textarea name="short_description" id="short_description" rows="3" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-[#1E3A8A]">{{ old('short_description', $news->short_description) }}</textarea>
                        @error('short_description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="mb-4">
                        <label for="content" class="block text-[#1E3A8A] text-sm font-medium mb-1">Content</label>
                        <textarea name="content" id="content" rows="10" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-[#1E3A8A]">{{ old('content', $news->content) }}</textarea>
                        @error('content')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image URL -->
                    <div class="mb-4">
                        <label for="image_url" class="block text-[#1E3A8A] text-sm font-medium mb-1">Image URL</label>
                        <input type="text" name="image_url" id="image_url" value="{{ old('image_url', $news->image_url) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-[#1E3A8A]">
                        @error('image_url')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if ($news->image_url)
                            <img src="{{ $news->image_url }}" alt="News Image" class="mt-2 max-h-40 object-cover rounded-lg">
                        @endif
                    </div>

                    <!-- Source URL -->
                    <div class="mb-4">
                        <label for="source_url" class="block text-[#1E3A8A] text-sm font-medium mb-1">Source URL</label>
                        <input type="url" name="source_url" id="source_url" value="{{ old('source_url', $news->source_url) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-[#1E3A8A]">
                        @error('source_url')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Published At -->
                    <div class="mb-4">
                        <label for="published_at" class="block text-[#1E3A8A] text-sm font-medium mb-1">Published At</label>
                        <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-[#1E3A8A]">
                        @error('published_at')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-[#2563EB] border border-transparent rounded-full font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:scale-95 transition ease-in-out duration-150 shadow-lg shadow-blue-200">
                            Update News
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>