<x-app-layout>
    <div class="min-h-screen bg-gray-50 flex flex-col">
        {{-- Header --}}
        <div class="bg-[#1E3A8A] px-5 lg:px-8 pt-12 lg:pt-16 pb-7 lg:pb-10 relative overflow-hidden rounded-b-[2rem] lg:rounded-none">
            <div class="absolute -top-6 -right-6 w-36 h-36 rounded-full border-[24px] border-white/10 pointer-events-none"></div>
            
            <div class="max-w-7xl mx-auto w-full relative z-10">
                <a href="{{ route('admin.news.index') }}"
                class="inline-flex items-center gap-1.5 text-white/60 hover:text-white text-sm font-semibold mb-4 active:opacity-60 transition-all text-decoration-none">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Berita
                </a>

                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 bg-white/20 rounded-xl px-3 py-1.5 mb-3">
                            <div class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-white text-xs font-bold tracking-wide">MODE ADMIN</span>
                        </div>
                        <h1 class="text-white text-2xl lg:text-4xl font-extrabold tracking-tight">Edit Berita</h1>
                        <p class="text-blue-200 text-sm mt-1">Perbarui detail berita atau sesuaikan pengaturan publikasi</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="flex-1 px-5 lg:px-8 py-6 lg:py-10">
            <div class="max-w-7xl mx-auto">
                <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data" 
                    x-data="{
                        form: {
                            title: '{{ old('title', $news->title) }}',
                            slug: '{{ old('slug', $news->slug) }}',
                            short_description: '{{ old('short_description', $news->short_description) }}',
                            content: `{!! addslashes(old('content', $news->content)) !!}`,
                            published_at: '{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}',
                        },
                        image_preview: '{{ $news->image_url ? $news->image_url : '' }}',
                        showPreview: false,
                        
                        updateSlug() {
                            this.form.slug = this.form.title.toLowerCase()
                                .replace(/[^\w ]+/g, '')
                                .replace(/ +/g, '-');
                        }
                    }"
                    class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                    @csrf
                    @method('PUT')

                    {{-- LEFT COLUMN: MAIN CONTENT --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white border border-gray-100 rounded-[2rem] shadow-sm p-6 lg:p-10 space-y-8">
                            
                            {{-- Judul --}}
                            <div class="space-y-2">
                                <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Judul Berita <span class="text-red-400">*</span></label>
                                <input type="text" name="title" x-model="form.title" @input="updateSlug" id="title_input" placeholder="Contoh: Gebyar Ramadhan 2025"
                                    class="w-full px-5 py-4 bg-[#EFF6FF] border-2 border-transparent rounded-2xl text-[#1E3A8A] text-lg font-bold placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:border-[#2563EB] transition-all duration-200 @error('title') border-red-400 bg-red-50 @enderror" required>
                                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Slug --}}
                            <div class="space-y-2">
                                <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Slug URL <span class="text-red-400">*</span></label>
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-400 text-sm hidden sm:inline">.../news/</span>
                                    <input type="text" name="slug" x-model="form.slug" id="slug_input" placeholder="gebyar-ramadhan-2025"
                                        class="flex-1 px-4 py-2 bg-[#F8FAFC] border border-gray-200 rounded-xl text-gray-500 text-xs @error('slug') border-red-400 @enderror" required>
                                </div>
                                @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Deskripsi Pendek --}}
                            <div class="space-y-2">
                                <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Headline Pendek</label>
                                <textarea name="short_description" x-model="form.short_description" id="short_description_input" rows="2" placeholder="Ringkasan singkat berita untuk kartu konten..."
                                    class="w-full px-5 py-4 bg-[#EFF6FF] border-2 border-transparent rounded-2xl text-[#1E3A8A] text-sm font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:border-[#2563EB] transition-all duration-200 resize-none"></textarea>
                            </div>

                            {{-- Konten Utama --}}
                            <div class="space-y-2 mt-8">
                                <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Isi Berita Lengkap</label>
                                <textarea name="content" x-model="form.content" id="content_input" rows="15" placeholder="Tuliskan isi berita selengkap-lengkapnya di sini..."
                                    class="w-full px-6 py-6 bg-[#EFF6FF] border-2 border-transparent rounded-[2rem] text-[#1E3A8A] text-base font-medium leading-relaxed placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:border-[#2563EB] transition-all duration-200 resize-none"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: SIDE SETTINGS --}}
                    <div class="space-y-6 lg:sticky lg:top-8">
                        
                        {{-- Thumbnail Card --}}
                        <div class="bg-white border border-gray-100 rounded-[2rem] shadow-sm p-6 overflow-hidden">
                            <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest mb-4">Thumbnail Berita</label>
                            <div class="relative group">
                                <input type="file" name="image" id="image_input" class="hidden" accept="image/*"
                                    @change="let file = $event.target.files[0]; if(file){ let reader = new FileReader(); reader.onload = (e) => { image_preview = e.target.result }; reader.readAsDataURL(file); }">
                                <label for="image_input" class="flex flex-col items-center justify-center w-full h-48 lg:h-56 bg-[#EFF6FF] border-2 border-dashed border-blue-200 rounded-[1.5rem] cursor-pointer hover:bg-blue-50 transition-all overflow-hidden relative">
                                    <template x-if="!image_preview">
                                        <div class="flex flex-col items-center text-center px-4">
                                            <svg class="w-10 h-10 text-[#2563EB] mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15m4.5-9l3 3m0 0l3-3m-3 3v12.75"/>
                                            </svg>
                                            <p class="text-[#2563EB] text-[11px] font-bold">Tap untuk upload</p>
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
                            @error('image') <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p> @enderror
                        </div>

                        {{-- Finalize Card --}}
                        <div class="bg-white border border-gray-100 rounded-[2rem] shadow-sm p-6 space-y-6">
                            {{-- Waktu Publish --}}
                            <div class="space-y-2">
                                <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Waktu Publish <span class="text-red-400">*</span></label>
                                <input type="datetime-local" name="published_at" x-model="form.published_at" id="published_at_input"
                                    class="w-full px-4 py-3 bg-[#EFF6FF] border-2 border-transparent rounded-xl text-[#1E3A8A] text-xs font-bold focus:outline-none focus:border-[#2563EB] transition-all duration-200 @error('published_at') border-red-400 bg-red-50 @enderror" required>
                                @error('published_at') <p class="text-red-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            {{-- Submit --}}
                            <div class="pt-4 space-y-3">
                                <button type="submit"
                                    class="w-full bg-[#2563EB] text-white font-extrabold py-4 rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-600 active:scale-[0.97] transition-all duration-200 text-sm uppercase tracking-wide">
                                    Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.news.index') }}" class="block w-full text-center py-3 bg-gray-50 text-gray-400 font-bold rounded-xl hover:bg-gray-100 transition-all text-[10px] uppercase tracking-widest">
                                    Batal
                                </a>
                            </div>
                        </div>

                        {{-- Floating Preview Button --}}
                        <button type="button" @click="showPreview = true" class="w-full flex items-center justify-center gap-2 bg-[#1E3A8A] text-white font-bold py-4 rounded-2xl shadow-lg active:scale-95 transition-all">
                            <svg class="w-5 h-5 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                            </svg>
                            Live Preview
                        </button>
                    </div>
                </form>

                {{-- MOBILE PREVIEW MODAL --}}
                <div x-show="showPreview" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display: none;">
                    <div @click.away="showPreview = false" class="relative bg-white w-full max-w-[375px] h-[700px] rounded-[3rem] shadow-2xl overflow-hidden border-[8px] border-gray-900 flex flex-col">
                        {{-- Phone Notch/Speaker --}}
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-6 bg-gray-900 rounded-b-2xl z-20"></div>
                        
                        {{-- Content --}}
                        <div class="flex-1 overflow-y-auto no-scrollbar bg-white">
                            <div class="relative w-full h-64 bg-gray-100">
                                <template x-if="image_preview">
                                    <img :src="image_preview" class="w-full h-full object-cover">
                                </template>
                                <button @click="showPreview = false" class="absolute top-8 right-4 w-10 h-10 bg-black/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white active:scale-90 transition-all">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="px-6 py-8">
                                <span class="bg-blue-50 text-blue-600 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest" x-text="new Date(form.published_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})"></span>
                                <h2 class="text-[#1E3A8A] text-2xl font-extrabold mt-3 leading-tight" x-text="form.title || 'Judul Berita'"></h2>
                                
                                <div class="mt-6 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">A</div>
                                    <div>
                                        <p class="text-[#1E3A8A] font-bold text-xs">Admin KeDai</p>
                                        <p class="text-gray-400 text-[10px]">Author</p>
                                    </div>
                                </div>

                                <div class="mt-8 prose prose-sm text-gray-700 leading-relaxed font-medium" x-html="form.content.replace(/\n/g, '<br>') || 'Isi berita akan muncul di sini...'"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>