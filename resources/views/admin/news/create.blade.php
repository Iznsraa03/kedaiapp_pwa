<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create News') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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
                                    // this.published_at = data.news.published_at; // published_at is set to now() in service
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
                        <div class="mb-6 flex justify-center space-x-4">
                            <button type="button" @click="manualEntry = false" :class="{ 'bg-indigo-600 text-white': !manualEntry, 'bg-gray-200 text-gray-800': manualEntry }" class="px-5 py-2 rounded-md font-medium transition-colors">
                                Fetch from URL
                            </button>
                            <button type="button" @click="manualEntry = true" :class="{ 'bg-indigo-600 text-white': manualEntry, 'bg-gray-200 text-gray-800': !manualEntry }" class="px-5 py-2 rounded-md font-medium transition-colors">
                                Manual Entry
                            </button>
                        </div>

                        <!-- Source URL (conditionally displayed) -->
                        <div class="mb-4" x-show="!manualEntry">
                            <label for="source_url" class="block text-sm font-medium text-gray-700">Source URL</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="url" name="source_url" id="source_url" x-model="source_url" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300" placeholder="https://example.com/news-article" :disabled="manualEntry">
                                <button type="button" @click="fetchNews" :disabled="loading || !source_url || manualEntry" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :class="loading || manualEntry ? 'opacity-50 cursor-not-allowed' : ''">
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
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" id="title" x-model="title" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" :required="manualEntry">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="mb-4">
                            <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                            <input type="text" name="slug" id="slug" x-model="slug" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" :required="manualEntry">
                            @error('slug')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Short Description -->
                        <div class="mb-4">
                            <label for="short_description" class="block text-sm font-medium text-gray-700">Short Description</label>
                            <textarea name="short_description" id="short_description" x-model="short_description" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                            @error('short_description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                            <textarea name="content" id="content" x-model="content" rows="10" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" :required="manualEntry"></textarea>
                            @error('content')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image URL -->
                        <div class="mb-4">
                            <label for="image_url" class="block text-sm font-medium text-gray-700">Image URL</label>
                            <input type="text" name="image_url" id="image_url" x-model="image_url" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('image_url')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <template x-if="image_url">
                                <img :src="image_url" alt="News Image" class="mt-2 max-h-40 object-cover rounded-md">
                            </template>
                        </div>

                        <!-- Published At -->
                        <div class="mb-4">
                            <label for="published_at" class="block text-sm font-medium text-gray-700">Published At</label>
                            <input type="datetime-local" name="published_at" id="published_at" x-model="published_at" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('published_at')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Create News
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>