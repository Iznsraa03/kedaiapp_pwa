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
            <h1 class="text-white text-2xl font-extrabold tracking-tight">Add News</h1>
            <p class="text-blue-200 text-sm mt-0.5">Tambah berita baru untuk aplikasi</p>
        </div>

        <div class="flex-1 px-5 py-6 space-y-4">
            <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm p-6">
                <form method="POST" action="{{ route('admin.news.store') }}" x-data="{
                        manualEntry: {{ old('source_url') ? 'false' : 'true' }}, // Default to manual if no old source_url
                        source_url: '{{ old('source_url') }}',
                        title: '{{ old('title') }}',
                        slug: '{{ old('slug') }}',
                        short_description: '{{ old('short_description') }}',
                        content: '{{ old('content') }}',
                        image_url: '{{ old('image_url') }}',
                        published_at: '{{ old('published_at') ? \Carbon\Carbon::parse(old('published_at'))->format('Y-m-d\TH:i') : \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}',
                        loading: false,
                        fetchNews: async function() {
                            this.loading = true;
                            try {
                                const response = await fetch('{{ route('admin.news.fetch-data') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify({ url: this.source_url })
                                });
                                const data = await response.json();
                                if (data.success) {
                                    this.title = data.news.title;
                                    this.slug = data.news.slug;
                                    this.short_description = data.news.short_description;
                                    this.content = data.news.content;
                                    this.image_url = data.news.image_url;
                                    alert('News content fetched successfully!');
                                } else {
                                    alert(data.message || 'Failed to fetch news content.');
                                }
                            } catch (error) {
                                console.error('Error fetching news:', error);
                                alert('An error occurred while fetching news content.');
                            } finally {
                                this.loading = false;
                            }
                        }
                    }">
                    @csrf

                    <!-- Mode Toggle -->
                    <div class="mb-6 flex justify-center space-x-4 p-1 bg-gray-100 rounded-full">
                        <button type="button" @click="manualEntry = false" :class="{ 'bg-[#2563EB] text-white shadow-md': !manualEntry, 'text-gray-600': manualEntry }" class="flex-1 px-4 py-2 rounded-full font-semibold text-sm transition-all duration-200">
                            Fetch from URL
                        </button>
                        <button type="button" @click="manualEntry = true" :class="{ 'bg-[#2563EB] text-white shadow-md': manualEntry, 'text-gray-600': !manualEntry }" class="flex-1 px-4 py-2 rounded-full font-semibold text-sm transition-all duration-200">
                            Manual Entry
                        </button>
                    </div>

                    <!-- Source URL (conditionally displayed) -->
                    <div class="mb-4" x-show="!manualEntry">
                        <label for="source_url" class="block text-[#1E3A8A] text-sm font-medium mb-1">Source URL</label>
                        <div class="flex rounded-lg shadow-sm">
                            <input type="url" name="source_url" id="source_url" x-model="source_url" class="block w-full rounded-l-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-[#1E3A8A]" placeholder="https://example.com/news-article" :disabled="manualEntry">
                            <button type="button" @click="fetchNews" :disabled="loading || !source_url || manualEntry" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-lg shadow-sm text-white bg-[#2563EB] hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" :class="loading || manualEntry ? 'opacity-50 cursor-not-allowed' : ''">
                                <span x-show="!loading">Fetch</span>
                                <span x-show="loading">Fetching...</span>
                            </button>
                        </div>
                        @error('source_url')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-[#1E3A8A] text-sm font-medium mb-1">Title</label>
                        <input type="text" name="title" id="title" x-model="title" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-[#1E3A8A]" :required="manualEntry">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="mb-4">
                        <label for="slug" class="block text-[#1E3A8A] text-sm font-medium mb-1">Slug</label>
                        <input type="text" name="slug" id="slug" x-model="slug" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-[#1E3A8A]" :required="manualEntry">
                        @error('slug')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Short Description -->
                    <div class="mb-4">
                        <label for="short_description" class="block text-[#1E3A8A] text-sm font-medium mb-1">Short Description</label>
                        <textarea name="short_description" id="short_description" x-model="short_description" rows="3" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-[#1E3A8A]"></textarea>
                        @error('short_description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="mb-4">
                        <label for="content" class="block text-[#1E3A8A] text-sm font-medium mb-1">Content</label>
                        <textarea name="content" id="content" x-model="content" rows="10" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-[#1E3A8A]" :required="manualEntry"></textarea>
                        @error('content')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image URL -->
                    <div class="mb-4">
                        <label for="image_url" class="block text-[#1E3A8A] text-sm font-medium mb-1">Image URL</label>
                        <input type="text" name="image_url" id="image_url" x-model="image_url" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-[#1E3A8A]">
                        @error('image_url')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <template x-if="image_url">
                            <img :src="image_url" alt="News Image" class="mt-2 max-h-40 object-cover rounded-lg">
                        </template>
                    </div>

                    <!-- Published At -->
                    <div class="mb-4">
                        <label for="published_at" class="block text-[#1E3A8A] text-sm font-medium mb-1">Published At</label>
                        <input type="datetime-local" name="published_at" id="published_at" x-model="published_at" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-[#1E3A8A]">
                        @error('published_at')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-[#2563EB] border border-transparent rounded-full font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:scale-95 transition ease-in-out duration-150 shadow-lg shadow-blue-200">
                            Create News
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>