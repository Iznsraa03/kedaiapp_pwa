<x-app-layout>
    <div class="min-h-screen bg-gray-50 flex flex-col">
        {{-- HEADER --}}
        <div class="bg-[#1E3A8A] px-5 lg:px-8 pt-12 lg:pt-16 pb-7 lg:pb-10 relative overflow-hidden hd-wobbly-lg mt-2 mx-2">
            <div class="max-w-7xl mx-auto w-full relative z-10">
                <a href="{{ route('admin.news.index') }}" class="inline-flex items-center gap-1.5 text-white/70 hover:text-white text-sm font-semibold mb-3 lg:mb-5 active:opacity-60 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>
                <h1 class="text-white text-2xl lg:text-3xl font-extrabold tracking-tight">Tambah Berita</h1>
                <p class="text-blue-200 text-sm mt-0.5 font-bold">Sebarkan informasi terbaru kepada komunitas</p>
            </div>
        </div>

        <div class="flex-1 px-5 lg:px-8 py-6 lg:py-10">
            <div class="max-w-7xl mx-auto">
                {{-- Error --}}
                @if ($errors->any())
                <div class="flex items-start gap-3 bg-red-50 border border-red-100 rounded-2xl px-4 py-3 mb-6">
                    <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                    </div>
                    <div class="space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <p class="text-red-500 text-sm font-medium leading-snug">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" x-data="{
                        form: {
                            source_url: @js(old('source_url', '')),
                            title: @js(old('title', '')),
                            slug: @js(old('slug', '')),
                            short_description: @js(old('short_description', '')),
                            content: @js(old('content', '')),
                            published_at: @js(old('published_at') ? \Carbon\Carbon::parse(old('published_at'))->format('Y-m-d\TH:i') : \Carbon\Carbon::now()->format('Y-m-d\TH:i')),
                        },
                        manualEntry: {{ old('source_url') && !($errors->has('title') || $errors->has('content') || $errors->has('image')) ? 'false' : 'true' }},
                        image_preview: null,
                        loading: false,
                        init() {
                            const draft = JSON.parse(localStorage.getItem('news_draft') || '{}');
                            if (draft.title && !this.form.title) this.form.title = draft.title;
                            if (draft.slug && !this.form.slug) this.form.slug = draft.slug;
                            if (draft.short_description && !this.form.short_description) this.form.short_description = draft.short_description;
                            if (draft.content && !this.form.content) this.form.content = draft.content;
                            if (draft.source_url && !this.form.source_url) this.form.source_url = draft.source_url;
                            
                            this.$watch('form.title', val => this.saveDraft());
                            this.$watch('form.slug', val => this.saveDraft());
                            this.$watch('form.short_description', val => this.saveDraft());
                            this.$watch('form.content', val => this.saveDraft());
                            this.$watch('form.source_url', val => this.saveDraft());
                        },
                        saveDraft() {
                            localStorage.setItem('news_draft', JSON.stringify({
                                title: this.form.title,
                                slug: this.form.slug,
                                short_description: this.form.short_description,
                                content: this.form.content,
                                source_url: this.form.source_url
                            }));
                        },
                        clearDraft() {
                            if (confirm('Are you sure you want to clear this draft?')) {
                                localStorage.removeItem('news_draft');
                                this.form.title = '';
                                this.form.slug = '';
                                this.form.short_description = '';
                                this.form.content = '';
                                this.form.source_url = '';
                                this.image_preview = null;
                            }
                        },
                        fetchNews: async function() {
                            this.loading = true;
                            this.form.title = '';
                            this.form.slug = '';
                            this.form.short_description = '';
                            this.form.content = '';
                            this.image_preview = null;
                            try {
                                const response = await fetch('{{ route('admin.news.fetch-data') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content
                                    },
                                    body: JSON.stringify({ url: this.form.source_url })
                                });
                                const data = await response.json();
                                if (data.success) {
                                    this.form.title = data.news.title;
                                    this.form.slug = data.news.slug;
                                    this.form.short_description = data.news.short_description;
                                    this.form.content = data.news.content;
                                    this.image_preview = data.news.image_url;
                                    this.saveDraft();
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
                        },
                        showPreview: false
                    }">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                        {{-- LEFT COLUMN: MAIN CONTENT --}}
                        <div class="lg:col-span-2 space-y-6">
                            <div class="bg-white hd-card border-none p-6 lg:p-10">
                                <!-- Mode Toggle -->
                                <div class="mb-8 flex justify-center space-x-2 p-1.5 bg-gray-50 hd-wobbly-md w-full max-w-sm mx-auto border-hd-ink/10">
                                    <button type="button" @click="manualEntry = false" :class="{ 'bg-[#1E3A8A] text-white hd-shadow-sm': !manualEntry, 'text-gray-400': manualEntry }" class="flex-1 px-4 py-2.5 rounded-xl font-bold text-xs transition-all duration-200">
                                        OTOMATIS
                                    </button>
                                    <button type="button" @click="manualEntry = true" :class="{ 'bg-[#1E3A8A] text-white hd-shadow-sm': manualEntry, 'text-gray-400': !manualEntry }" class="flex-1 px-4 py-2.5 rounded-xl font-bold text-xs transition-all duration-200">
                                        MANUAL
                                    </button>
                                </div>

                                <!-- Source URL -->
                                <div class="mb-10 space-y-2" x-show="!manualEntry" x-transition>
                                    <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">URL Sumber Berita</label>
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 flex items-center bg-[#EFF6FF] hd-wobbly-md px-4 py-1.5 border-hd-ink/10">
                                            <svg class="w-5 h-5 text-blue-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.364 0a4.5 4.5 0 01-1.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.364 0l1.757-1.757m-1.757 1.757L13.19 8.688" />
                                            </svg>
                                            <input type="url" name="source_url" id="source_url_input" x-model="form.source_url" placeholder="https://news.detik.com/..." class="flex-1 bg-transparent border-none outline-none text-[#1E3A8A] text-sm font-bold py-2.5" :disabled="manualEntry">
                                        </div>
                                        <x-atoms.button type="button" @click="fetchNews" variant="primary" size="lg" :handdrawn="true" ::disabled="loading || !form.source_url || manualEntry">
                                            <span x-show="!loading">Fetch</span>
                                            <div x-show="loading" class="flex items-center gap-2">
                                                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </div>
                                        </x-atoms.button>
                                    </div>
                                    @error('source_url') <p class="text-sm text-red-600 font-bold mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-6">
                                    <!-- Title -->
                                    <div class="space-y-2">
                                        <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest text-shadow-sm">Judul Berita</label>
                                        <input type="text" name="title" id="title_input" x-model="form.title" placeholder="Tulis judul yang menarik..." 
                                            class="w-full px-5 py-4 bg-[#EFF6FF] hd-wobbly-md border-hd-ink/10 text-[#1E3A8A] text-lg font-bold placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:border-[#1E3A8A] transition-all" :required="manualEntry">
                                        @error('title') <p class="text-sm text-red-600 font-bold">{{ $message }}</p> @enderror
                                    </div>

                                    <!-- Short Description -->
                                    <div class="space-y-2">
                                        <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Deskripsi Singkat</label>
                                        <textarea name="short_description" id="short_description_input" x-model="form.short_description" rows="3" placeholder="Ringkasan singkat untuk tampilan list..."
                                            class="w-full px-5 py-4 bg-[#EFF6FF] hd-wobbly-md border-hd-ink/10 text-[#1E3A8A] text-sm font-bold focus:outline-none focus:border-[#1E3A8A] transition-all resize-none"></textarea>
                                        @error('short_description') <p class="text-sm text-red-600 font-bold">{{ $message }}</p> @enderror
                                    </div>

                                    <!-- Content -->
                                    <div class="space-y-2">
                                        <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Isi Berita Lengkap</label>
                                        <div class="bg-white hd-wobbly-lg border-hd-ink/10 overflow-hidden focus-within:border-[#1E3A8A] transition-all">
                                            <textarea name="content" id="content_input" x-model="form.content" rows="15" placeholder="Tuliskan berita lengkap di sini..." 
                                                class="w-full px-6 py-6 bg-transparent border-none outline-none text-[#1E3A8A] text-base font-bold leading-relaxed resize-none" :required="manualEntry"></textarea>
                                        </div>
                                        @error('content') <p class="text-sm text-red-600 font-bold">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT COLUMN: SIDE SETTINGS --}}
                        <div class="space-y-6 lg:sticky lg:top-8">
                            
                            {{-- Image Upload Card --}}
                            <div class="bg-white hd-card border-none p-6">
                                <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest mb-4">Thumbnail Berita</label>
                                <div class="relative group">
                                    <input type="file" name="image" id="image_input" accept="image/*" class="hidden" @change="handleImageUpload">
                                    <label for="image_input" class="block w-full h-48 lg:h-56 bg-gray-50 hd-wobbly-md border-hd-ink/10 cursor-pointer hover:bg-blue-50 transition-all overflow-hidden relative border-dashed border-2">
                                        <template x-if="!image_preview">
                                            <div class="flex flex-col items-center justify-center h-full text-center px-4">
                                                <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15m4.5-9l3 3m0 0l3-3m-3 3v12.75"/>
                                                </svg>
                                                <p class="text-gray-400 text-[10px] font-bold">Tap untuk Pilih Gambar</p>
                                            </div>
                                        </template>
                                        <template x-if="image_preview">
                                            <div class="w-full h-full relative">
                                                <img :src="image_preview" class="w-full h-full object-cover">
                                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <span class="text-white text-xs font-bold">Ganti Gambar</span>
                                                </div>
                                            </div>
                                        </template>
                                    </label>
                                </div>
                                @error('image') <p class="text-sm text-red-600 font-bold mt-2">{{ $message }}</p> @enderror
                            </div>

                            {{-- Publishing Card --}}
                            <div class="bg-white hd-card border-none p-6 space-y-5">
                                <div class="space-y-2">
                                    <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Slug (URL)</label>
                                    <input type="text" name="slug" id="slug_input" x-model="form.slug" placeholder="slug-berita..." 
                                        class="w-full px-4 py-3 bg-[#EFF6FF] hd-wobbly-md border-hd-ink/10 text-[#1E3A8A] text-xs font-bold outline-none focus:border-[#1E3A8A]" :required="manualEntry">
                                    @error('slug') <p class="text-xs text-red-600 font-bold mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Waktu Publish</label>
                                    <input type="datetime-local" name="published_at" id="published_at_input" x-model="form.published_at" 
                                        class="w-full px-4 py-3 bg-[#EFF6FF] hd-wobbly-md border-hd-ink/10 text-[#1E3A8A] text-xs font-bold outline-none focus:border-[#1E3A8A]">
                                    @error('published_at') <p class="text-xs text-red-600 font-bold mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="pt-4 space-y-3">
                                    <x-atoms.button type="submit" @click="localStorage.removeItem('news_draft')" variant="primary" size="lg" :handdrawn="true" class="w-full uppercase tracking-widest text-xs">
                                        Publikasikan
                                    </x-atoms.button>
                                    <button type="button" @click="clearDraft" class="w-full bg-gray-50 text-gray-400 font-bold py-3 rounded-xl hover:bg-red-50 hover:text-red-500 transition-all text-[10px] uppercase tracking-widest">
                                        Hapus Draft
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MOBILE PREVIEW MODAL --}}
                    <div x-show="showPreview" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display: none;">
                        <div @click.away="showPreview = false" class="relative bg-white w-full max-w-[375px] h-[700px] rounded-[3rem] shadow-2xl overflow-hidden border-[8px] border-gray-900 flex flex-col">
                            {{-- Phone Notch/Speaker --}}
                            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-6 bg-gray-900 rounded-b-2xl z-20"></div>
                            
                            {{-- News Preview Content --}}
                            <div class="flex-1 overflow-y-auto no-scrollbar bg-white">
                                <div class="relative w-full h-64 bg-gray-100">
                                    <template x-if="image_preview">
                                        <img :src="image_preview" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!image_preview">
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                        </div>
                                    </template>
                                    <button @click="showPreview = false" class="absolute top-8 right-4 w-10 h-10 bg-black/20 backdrop-blur-md rounded-full flex items-center justify-center text-white active:scale-90 transition-all">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="px-5 py-6 space-y-4">
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2.5 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-full uppercase tracking-wider">News</span>
                                            <span class="text-gray-400 text-[10px] font-medium" x-text="new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })"></span>
                                        </div>
                                        <h2 class="text-[#1E3A8A] text-xl font-extrabold leading-tight" x-text="form.title || 'Untiteld News'"></h2>
                                    </div>
                                    
                                    <p class="text-gray-500 text-sm font-medium leading-relaxed italic border-l-4 border-blue-200 pl-4" x-text="form.short_description || 'No description provided.'"></p>
                                    
                                    <div class="prose prose-sm text-gray-700 leading-relaxed font-medium" x-html="form.content.replace(/\n/g, '<br>') || 'Start writing to see the story unfold...'"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- FLOATING PREVIEW BUTTON --}}
                    <x-atoms.button type="button" @click="showPreview = true" variant="primary" size="lg" :handdrawn="true" class="fixed bottom-8 right-8 z-[90] shadow-2xl group overflow-hidden">
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                            </svg>
                            <span class="text-sm font-bold pr-2 whitespace-nowrap">Preview</span>
                        </div>
                    </x-atoms.button>
                        
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>