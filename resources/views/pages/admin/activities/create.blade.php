    <x-app-layout>
    <div class="min-h-screen bg-gray-50 flex flex-col">
        {{-- Header --}}
        <div class="bg-[#1E3A8A] px-5 lg:px-8 pt-12 lg:pt-16 pb-7 lg:pb-10 relative overflow-hidden rounded-b-[2rem] lg:rounded-none">
            <div class="absolute -top-6 -right-6 w-36 h-36 rounded-full border-[24px] border-white/10 pointer-events-none"></div>
            
            <div class="max-w-7xl mx-auto w-full relative z-10">
                <a href="{{ route('admin.activities.index') }}"
                class="inline-flex items-center gap-1.5 text-white/60 hover:text-white text-sm font-semibold mb-4 active:opacity-60 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kelola Kegiatan
                </a>

                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 bg-white/20 rounded-xl px-3 py-1.5 mb-3">
                            <div class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-white text-xs font-bold tracking-wide">MODE ADMIN</span>
                        </div>
                        <h1 class="text-white text-2xl lg:text-4xl font-extrabold tracking-tight">Tambah Kegiatan</h1>
                        <p class="text-blue-200 text-sm mt-1">Isi detail kegiatan baru untuk aplikasi</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="flex-1 px-5 lg:px-8 py-6 lg:py-10">
            <div class="max-w-7xl mx-auto">
                <form method="POST" action="{{ route('admin.activities.store') }}" enctype="multipart/form-data" 
                    x-data="{
                        form: {
                            title: '{{ old('title') }}',
                            emoji: '{{ old('emoji') }}',
                            location: '{{ old('location') }}',
                            description: '{{ old('description') }}',
                            starts_at: '{{ old('starts_at') }}',
                            ends_at: '{{ old('ends_at') }}',
                            status: '{{ old('status', 'upcoming') }}',
                        },
                        image_preview: null,
                        showPreview: false,
                        init() {
                            const draft = JSON.parse(localStorage.getItem('activity_draft') || '{}');
                            if (draft.title && !this.form.title) this.form.title = draft.title;
                            if (draft.emoji && !this.form.emoji) this.form.emoji = draft.emoji;
                            if (draft.location && !this.form.location) this.form.location = draft.location;
                            if (draft.description && !this.form.description) this.form.description = draft.description;
                            if (draft.starts_at && !this.form.starts_at) this.form.starts_at = draft.starts_at;
                            if (draft.ends_at && !this.form.ends_at) this.form.ends_at = draft.ends_at;
                            if (draft.status && !this.form.status) this.form.status = draft.status;
                            
                            this.$watch('form.title', val => this.saveDraft());
                            this.$watch('form.emoji', val => this.saveDraft());
                            this.$watch('form.location', val => this.saveDraft());
                            this.$watch('form.description', val => this.saveDraft());
                            this.$watch('form.starts_at', val => this.saveDraft());
                            this.$watch('form.ends_at', val => this.saveDraft());
                            this.$watch('form.status', val => this.saveDraft());
                        },
                        saveDraft() {
                            localStorage.setItem('activity_draft', JSON.stringify({
                                title: this.form.title,
                                emoji: this.form.emoji,
                                location: this.form.location,
                                description: this.form.description,
                                starts_at: this.form.starts_at,
                                ends_at: this.form.ends_at,
                                status: this.form.status
                            }));
                        },
                        clearDraft() {
                            if (confirm('Bersihkan draf kegiatan ini?')) {
                                localStorage.removeItem('activity_draft');
                                location.reload();
                            }
                        }
                    }"
                    class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                    @csrf

                    {{-- LEFT COLUMN: MAIN CONTENT --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white border border-gray-100 rounded-[2rem] shadow-sm p-6 lg:p-10 space-y-8">
                            
                            {{-- Judul --}}
                            <div class="space-y-2">
                                <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Judul Kegiatan <span class="text-red-400">*</span></label>
                                <input type="text" name="title" x-model="form.title" id="title_input" placeholder="Contoh: Gathering Anggota 2025"
                                    class="w-full px-5 py-4 bg-[#EFF6FF] border-2 border-transparent rounded-2xl text-[#1E3A8A] text-lg font-bold placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:border-[#2563EB] transition-all duration-200 @error('title') border-red-400 bg-red-50 @enderror" required>
                                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">
                                {{-- Emoji --}}
                                <div class="space-y-3">
                                    <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Visual Emoji</label>
                                    <div class="flex gap-3">
                                        <input type="text" name="emoji" x-model="form.emoji" maxlength="10" id="emoji_input"
                                            placeholder="📍"
                                            class="w-20 h-20 bg-[#EFF6FF] border-2 border-transparent rounded-[1.5rem] text-[#1E3A8A] text-3xl text-center focus:outline-none focus:border-[#2563EB] transition-all duration-200">
                                        <div class="flex-1 grid grid-cols-5 gap-2">
                                            @foreach(['🎉','☕','🏆','📚','🎨','🎤','🏋️','🌿','💼','🎯'] as $em)
                                            <button type="button" @click="form.emoji = '{{ $em }}'"
                                                class="text-xl aspect-square bg-gray-50 rounded-xl hover:bg-blue-100 active:scale-90 transition-all flex items-center justify-center">{{ $em }}</button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- Lokasi --}}
                                <div class="space-y-3">
                                    <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Lokasi</label>
                                    <div class="relative h-20">
                                        <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <input type="text" name="location" x-model="form.location" id="location_input" placeholder="Contoh: Aula Utama Gedung A"
                                            class="w-full h-full pl-14 pr-5 bg-[#EFF6FF] border-2 border-transparent rounded-[1.5rem] text-[#1E3A8A] text-sm font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:border-[#2563EB] transition-all duration-200">
                                    </div>
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="space-y-2 mt-8">
                                <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Detail Deskripsi</label>
                                <textarea name="description" x-model="form.description" id="description_input" rows="10" placeholder="Jelaskan detail kegiatan di sini agar peserta lebih tertarik…"
                                    class="w-full px-6 py-6 bg-[#EFF6FF] border-2 border-transparent rounded-[2rem] text-[#1E3A8A] text-base font-medium leading-relaxed placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:border-[#2563EB] transition-all duration-200 resize-none"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: SIDE SETTINGS --}}
                    <div class="space-y-6 lg:sticky lg:top-8">
                        
                        {{-- Thumbnail Card --}}
                        <div class="bg-white border border-gray-100 rounded-[2rem] shadow-sm p-6 overflow-hidden">
                            <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest mb-4">Thumbnail / Poster</label>
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

                        {{-- Schedule & Status Card --}}
                        <div class="bg-white border border-gray-100 rounded-[2rem] shadow-sm p-6 space-y-6">
                            {{-- Tanggal & Waktu --}}
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Waktu Mulai <span class="text-red-400">*</span></label>
                                    <input type="datetime-local" name="starts_at" x-model="form.starts_at" id="starts_at_input"
                                        class="w-full px-4 py-3 bg-[#EFF6FF] border-2 border-transparent rounded-xl text-[#1E3A8A] text-xs font-bold focus:outline-none focus:border-[#2563EB] transition-all duration-200 @error('starts_at') border-red-400 bg-red-50 @enderror" required>
                                    @error('starts_at') <p class="text-red-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Waktu Selesai <span class="text-red-400">*</span></label>
                                    <input type="datetime-local" name="ends_at" x-model="form.ends_at" id="ends_at_input"
                                        class="w-full px-4 py-3 bg-[#EFF6FF] border-2 border-transparent rounded-xl text-[#1E3A8A] text-xs font-bold focus:outline-none focus:border-[#2563EB] transition-all duration-200 @error('ends_at') border-red-400 bg-red-50 @enderror" required>
                                    @error('ends_at') <p class="text-red-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="space-y-3">
                                <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Status Kegiatan <span class="text-red-400">*</span></label>
                                <div class="flex flex-col gap-2">
                                    @foreach(['upcoming' => '📅 Akan Datang', 'open' => '✅ Buka', 'closed' => '🔒 Tutup'] as $val => $label)
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="status" value="{{ $val }}" x-model="form.status" class="hidden peer">
                                        <div class="flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-transparent bg-gray-50 text-gray-400 text-xs font-bold
                                            peer-checked:bg-blue-50 peer-checked:text-[#2563EB] peer-checked:border-[#2563EB] group-hover:bg-gray-100 transition-all duration-200">
                                            <div class="w-4 h-4 rounded-full border-2 border-gray-300 peer-checked:border-[#2563EB] relative flex items-center justify-center">
                                                <div class="w-1.5 h-1.5 rounded-full bg-[#2563EB] hidden peer-checked:block"></div>
                                            </div>
                                            {{ $label }}
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="pt-4 space-y-3">
                                <button type="submit" @click="localStorage.removeItem('activity_draft')"
                                    class="w-full bg-[#2563EB] text-white font-extrabold py-4 rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-600 active:scale-[0.97] transition-all duration-200 text-sm uppercase tracking-wide">
                                    Simpan Kegiatan
                                </button>
                                <button type="button" @click="clearDraft" class="w-full bg-gray-50 text-gray-400 font-bold py-3 rounded-xl hover:bg-red-50 hover:text-red-500 transition-all text-[10px] uppercase tracking-widest">
                                    Clear Draft
                                </button>
                            </div>
                        </div>

                    </div>
                </form>

                {{-- MOBILE PREVIEW MODAL --}}
                <div x-show="showPreview" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display: none;">
                    <div @click.away="showPreview = false" class="relative bg-white w-full max-w-[375px] h-[700px] rounded-[3rem] shadow-2xl overflow-hidden border-[8px] border-gray-900 flex flex-col">
                        {{-- Phone Notch/Speaker --}}
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-6 bg-gray-900 rounded-b-2xl z-20"></div>
                        
                        {{-- Activity Preview Content --}}
                        <div class="flex-1 overflow-y-auto no-scrollbar bg-white">
                            <div class="relative w-full h-80 bg-gray-100">
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
                                <div class="absolute top-8 left-4 px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-white text-[10px] font-bold uppercase tracking-widest border border-white/30">
                                    Activity
                                </div>
                                <button @click="showPreview = false" class="absolute top-8 right-4 w-10 h-10 bg-black/20 backdrop-blur-md rounded-full flex items-center justify-center text-white active:scale-90 transition-all">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-white to-transparent"></div>
                                <div class="absolute bottom-6 left-6 text-4xl" x-text="form.emoji"></div>
                            </div>
                            
                            <div class="px-6 pb-20 -mt-2 relative z-10">
                                <h2 class="text-[#1E3A8A] text-2xl font-extrabold leading-tight" x-text="form.title || 'Untiteld Activity'"></h2>
                                
                                <div class="mt-6 space-y-4">
                                    <div class="flex items-start gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Location</p>
                                            <p class="text-sm font-semibold text-gray-700" x-text="form.location || 'No location set'"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Time</p>
                                            <p class="text-sm font-semibold text-gray-700" x-text="form.starts_at ? new Date(form.starts_at).toLocaleString('id-ID', {day:'numeric', month:'short', hour:'2-digit', minute:'2-digit'}) : 'Set start time'"></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-8 pt-8 border-t border-gray-100">
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">About Activity</p>
                                    <div class="prose prose-sm text-gray-700 leading-relaxed font-medium" x-html="form.description.replace(/\n/g, '<br>') || 'Tell us more about this activity...'"></div>
                                </div>

                                <div class="mt-8">
                                    <button type="button" class="w-full bg-[#1E3A8A] text-white font-extrabold py-4 rounded-2xl shadow-lg shadow-blue-100">
                                        Join Activity
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FLOATING PREVIEW BUTTON --}}
                <button type="button" @click="showPreview = true" class="fixed bottom-8 right-8 z-[90] bg-[#1E3A8A] text-white p-4 rounded-2xl shadow-2xl hover:scale-110 active:scale-90 transition-all group overflow-hidden">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                        </svg>
                        <span class="text-sm font-bold pr-2">Preview</span>
                    </div>
                    <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
