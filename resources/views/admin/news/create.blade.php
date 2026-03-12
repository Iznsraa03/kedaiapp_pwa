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
                <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" x-data="{
                        manualEntry: {{ old('source_url') ? 'false' : 'true' }},
                        source_url: '{{ old('source_url') }}',
                        title: '{{ old('title') }}',
                        slug: '{{ old('slug') }}',
                        short_description: '{{ old('short_description') }}',
                        content: '{{ old('content') }}',
                        image_preview: null, // For image file preview
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
                                    // For image_url, if fetched, we display it as a preview. No actual upload yet.
                                    this.image_preview = data.news.image_url;
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
                        },
                        handleImageUpload: function(event) {
                            const file = event.target.files[0];
                            if (file) {
                                this.image_preview = URL.createObjectURL(file);
                            } else {
                                this.image_preview = null;
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
                    <div class="mb-4 space-y-1.5" x-show="!manualEntry">
                        <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Source URL</label>
                        <div class="field-input {{ $errors->has('source_url') ? 'error' : '' }}">
                            <span class="icon">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.364 0a4.5 4.5 0 01-1.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.364 0l1.757-1.757m-1.757 1.757L13.19 8.688" />
                                </svg>
                            </span>
                            <input type="url" name="source_url" id="source_url" x-model="source_url" placeholder="https://example.com/news-article" :disabled="manualEntry">
                            <button type="button" @click="fetchNews" :disabled="loading || !source_url || manualEntry" class="eye-btn bg-[#2563EB] text-white px-3 h-full rounded-r-lg" :class="loading || manualEntry ? 'opacity-50 cursor-not-allowed' : ''">
                                <span x-show="!loading">Fetch</span>
                                <span x-show="loading">Fetching...</span>
                            </button>
                        </div>
                        @error('source_url')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div class="mb-4 space-y-1.5">
                        <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Title</label>
                        <div class="field-input {{ $errors->has('title') ? 'error' : '' }}">
                            <span class="icon">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </span>
                            <input type="text" name="title" id="title" x-model="title" placeholder="News Title" :required="manualEntry">
                        </div>
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="mb-4 space-y-1.5">
                        <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Slug</label>
                        <div class="field-input {{ $errors->has('slug') ? 'error' : '' }}">
                            <span class="icon">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.364 0a4.5 4.5 0 01-1.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.364 0l1.757-1.757m-1.757 1.757L13.19 8.688" />
                                </svg>
                            </span>
                            <input type="text" name="slug" id="slug" x-model="slug" placeholder="news-title-slug" :required="manualEntry">
                        </div>
                        @error('slug')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Short Description -->
                    <div class="mb-4 space-y-1.5">
                        <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Short Description</label>
                        <div class="field-input {{ $errors->has('short_description') ? 'error' : '' }}">
                            <span class="icon">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </span>
                            <textarea name="short_description" id="short_description" x-model="short_description" rows="3" class="block w-full h-full bg-transparent border-none outline-none text-sm font-medium text-[#1E3A8A] p-3" placeholder="Short description of the news"></textarea>
                        </div>
                        @error('short_description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="mb-4 space-y-1.5">
                        <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Content</label>
                        <div class="field-input {{ $errors->has('content') ? 'error' : '' }}">
                            <span class="icon">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </span>
                            <textarea name="content" id="content" x-model="content" rows="10" class="block w-full h-full bg-transparent border-none outline-none text-sm font-medium text-[#1E3A8A] p-3" placeholder="Full content of the news article" :required="manualEntry"></textarea>
                        </div>
                        @error('content')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-4 space-y-1.5">
                        <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Image</label>
                        <div class="field-input {{ $errors->has('image') ? 'error' : '' }}">
                            <span class="icon">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </span>
                            <input type="file" name="image" id="image" accept="image/*" class="block w-full h-full bg-transparent border-none outline-none text-sm font-medium text-[#1E3A8A] p-3" @change="handleImageUpload">
                        </div>
                        @error('image')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <template x-if="image_preview">
                            <img :src="image_preview" alt="Image Preview" class="mt-2 max-h-40 object-cover rounded-lg">
                        </template>
                    </div>

                    <!-- Published At -->
                    <div class="mb-4 space-y-1.5">
                        <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Published At</label>
                        <div class="field-input {{ $errors->has('published_at') ? 'error' : '' }}">
                            <span class="icon">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12v-.008z" />
                                </svg>
                            </span>
                            <input type="datetime-local" name="published_at" id="published_at" x-model="published_at" class="block w-full h-full bg-transparent border-none outline-none text-sm font-medium text-[#1E3A8A] p-3">
                        </div>
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