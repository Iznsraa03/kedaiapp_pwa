<x-app-layout>
    <div class="min-h-screen bg-gray-50 flex flex-col" 
        x-data="{ 
            form: {
                title: '{{ old('title', $activity->title) }}',
                emoji: '{{ old('emoji', $activity->emoji) }}',
                location: '{{ old('location', $activity->location) }}',
                starts_at: '{{ old('starts_at', $activity->starts_at->format('Y-m-d\TH:i')) }}',
                ends_at: '{{ old('ends_at', $activity->ends_at->format('Y-m-d\TH:i')) }}',
                status: '{{ old('status', $activity->status) }}',
                description: @js(old('description', $activity->description))
            },
            showPreview: false,
            image_preview: '{{ $activity->image_url ? $activity->image_url : '' }}',
            
            init() {
                // Initialize if needed
            }
        }">
        
        {{-- HEADER --}}
        <div class="bg-[#1E3A8A] px-5 lg:px-8 pt-12 lg:pt-16 pb-7 lg:pb-10 relative overflow-hidden rounded-b-[2rem] lg:rounded-none">
            <div class="absolute -top-6 -right-6 w-36 h-36 rounded-full border-[24px] border-white/10 pointer-events-none"></div>
            
            <div class="max-w-7xl mx-auto w-full relative z-10">
                <a href="{{ route('admin.activities.index') }}"
                   class="inline-flex items-center gap-1.5 text-white/60 hover:text-white text-sm font-semibold mb-4 active:opacity-60 transition-all text-decoration-none">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Kegiatan
                </a>

                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 bg-white/20 rounded-xl px-3 py-1.5 mb-3">
                            <div class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-white text-xs font-bold tracking-wide">MODE ADMIN</span>
                        </div>
                        <h1 class="text-white text-2xl lg:text-4xl font-extrabold tracking-tight">Edit Kegiatan</h1>
                        <p class="text-blue-200 text-sm mt-1">Sesuaikan detail kegiatan untuk anggota</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="flex-1 px-5 lg:px-8 py-6 lg:py-10">
            <div class="max-w-7xl mx-auto">
                {{-- Error --}}
                @if ($errors->any())
                <div class="mb-8 flex items-start gap-4 bg-red-50 border-l-4 border-red-500 rounded-2xl px-6 py-4 shadow-sm animate-shake">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-red-800 font-bold text-sm">Ada kesalahan input:</h3>
                        <ul class="mt-1 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li class="text-red-600 text-xs font-medium">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <form action="{{ route('admin.activities.update', $activity) }}" method="POST" enctype="multipart/form-data" 
                    @submit="localStorage.removeItem('activity_draft')"
                    class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                    @csrf
                    @method('PUT')

                    {{-- LEFT COLUMN: MAIN FORM --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white border border-gray-100 rounded-[2rem] shadow-sm p-6 lg:p-10 space-y-8">
                            
                            {{-- Row: Emoji + Title --}}
                            <div class="flex flex-col sm:flex-row gap-6">
                                <div class="w-24 space-y-2">
                                    <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest text-center">Icon</label>
                                    <input type="text" name="emoji" x-model="form.emoji" id="emoji_input" placeholder="🔥"
                                        class="w-full px-4 py-4 bg-[#EFF6FF] border-2 border-transparent rounded-2xl text-center text-3xl focus:outline-none focus:border-[#2563EB] transition-all">
                                </div>
                                <div class="flex-1 space-y-2">
                                    <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Judul Kegiatan <span class="text-red-400">*</span></label>
                                    <input type="text" name="title" x-model="form.title" id="title_input" placeholder="Contoh: Rapat Koordinasi Rutin"
                                        class="w-full px-5 py-4 bg-[#EFF6FF] border-2 border-transparent rounded-2xl text-[#1E3A8A] text-lg font-bold placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:border-[#2563EB] transition-all duration-200" required>
                                </div>
                            </div>

                            {{-- Location --}}
                            <div class="space-y-2">
                                <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Lokasi</label>
                                <div class="relative group">
                                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#2563EB] transition-colors">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </span>
                                    <input type="text" name="location" x-model="form.location" id="location_input" placeholder="Gedung KeDai Lt. 3"
                                        class="w-full pl-14 pr-5 py-4 bg-[#EFF6FF] border-2 border-transparent rounded-2xl text-[#1E3A8A] text-sm font-bold focus:outline-none focus:border-[#2563EB] transition-all duration-200">
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="space-y-2">
                                <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Deskripsi Kegiatan</label>
                                <textarea name="description" x-model="form.description" id="description_input" rows="8" placeholder="Tuliskan jadwal, agenda, atau info penting lainnya..."
                                    class="w-full px-6 py-6 bg-[#EFF6FF] border-2 border-transparent rounded-[2rem] text-[#1E3A8A] text-base font-medium leading-relaxed focus:outline-none focus:border-[#2563EB] transition-all duration-200 resize-none font-sans"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: SIDEBAR SETTINGS --}}
                    <div class="space-y-6 lg:sticky lg:top-8">
                        
                        {{-- Image Config Card --}}
                        <div class="bg-white border border-gray-100 rounded-[2rem] shadow-sm p-6 overflow-hidden">
                            <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest mb-4">Gambar / Poster</label>
                            
                            <div class="relative group">
                                <input type="file" name="image" id="image_input" class="hidden" accept="image/*"
                                    @change="let file = $event.target.files[0]; if(file){ let reader = new FileReader(); reader.onload = (e) => { image_preview = e.target.result }; reader.readAsDataURL(file); }">
                                <label for="image_input" class="flex flex-col items-center justify-center w-full h-48 bg-[#EFF6FF] border-2 border-dashed border-blue-200 rounded-[1.5rem] cursor-pointer hover:bg-blue-50 transition-all overflow-hidden relative">
                                    <template x-if="!image_preview">
                                        <div class="flex flex-col items-center text-center px-4">
                                            <svg class="w-10 h-10 text-[#2563EB] mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15m4.5-9l3 3m0 0l3-3m-3 3v12.75"/>
                                            </svg>
                                            <p class="text-[#2563EB] text-[11px] font-bold">Tap untuk upload gambar</p>
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
                        </div>

                        {{-- Schedule & Status Card --}}
                        <div class="bg-white border border-gray-100 rounded-[2rem] shadow-sm p-6 space-y-6">
                            
                            {{-- Date Row --}}
                            <div class="grid grid-cols-1 gap-4">
                                <div class="space-y-2 text-decoration-none">
                                    <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Waktu Mulai <span class="text-red-400">*</span></label>
                                    <input type="datetime-local" name="starts_at" x-model="form.starts_at" id="starts_at_input"
                                        class="w-full px-4 py-3 bg-[#EFF6FF] border-2 border-transparent rounded-xl text-[#1E3A8A] text-xs font-bold focus:outline-none focus:border-[#2563EB] transition-all duration-200" required>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Waktu Selesai <span class="text-red-400">*</span></label>
                                    <input type="datetime-local" name="ends_at" x-model="form.ends_at" id="ends_at_input"
                                        class="w-full px-4 py-3 bg-[#EFF6FF] border-2 border-transparent rounded-xl text-[#1E3A8A] text-xs font-bold focus:outline-none focus:border-[#2563EB] transition-all duration-200" required>
                                </div>
                            </div>

                            {{-- Status Radio --}}
                            <div class="space-y-3">
                                <label class="block text-[#1E3A8A] text-[11px] font-bold uppercase tracking-widest">Status Presensi</label>
                                <div class="grid grid-cols-1 gap-2">
                                    @foreach(['upcoming' => 'Antri (Upcoming)', 'open' => 'Dibuka (Open)', 'closed' => 'Ditutup (Closed)'] as $val => $label)
                                    <label class="contents">
                                        <input type="radio" name="status" value="{{ $val }}" x-model="form.status" class="hidden peer">
                                        <div class="px-4 py-3 rounded-xl border-2 border-gray-50 bg-gray-50 text-gray-400 text-xs font-bold cursor-pointer peer-checked:border-[#2563EB] peer-checked:bg-blue-50 peer-checked:text-[#2563EB] transition-all">
                                            {{ $label }}
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Actions Card --}}
                        <div class="bg-white border border-gray-100 rounded-[2rem] shadow-sm p-6 space-y-3">
                            <button type="submit"
                                class="w-full bg-[#2563EB] text-white font-extrabold py-4 rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-600 active:scale-[0.97] transition-all duration-200 text-sm uppercase tracking-wide">
                                Simpan Perubahan
                            </button>
                            <button type="button" @click="showPreview = true" class="w-full flex items-center justify-center gap-2 bg-[#1E3A8A] text-white font-bold py-4 rounded-2xl active:scale-95 transition-all">
                                <svg class="w-5 h-5 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                </svg>
                                Mobile Preview
                            </button>
                        </div>
                    </div>
                </form>

                {{-- MOBILE PREVIEW MODAL --}}
                <div x-show="showPreview" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display: none;">
                    <div @click.away="showPreview = false" class="relative bg-white w-full max-w-[375px] h-[700px] rounded-[3rem] shadow-2xl overflow-hidden border-[8px] border-gray-900 flex flex-col">
                        {{-- Phone Notch --}}
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-6 bg-gray-900 rounded-b-2xl z-20"></div>
                        
                        {{-- App Content Preview --}}
                        <div class="flex-1 overflow-y-auto no-scrollbar bg-white pt-10 px-6">
                            <div class="flex items-center justify-between mb-8">
                                <button @click="showPreview = false" class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center text-[#1E3A8A]">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                                </button>
                                <span class="bg-blue-50 text-[#2563EB] text-[10px] font-extrabold px-3 py-1.5 rounded-xl uppercase tracking-widest">Detail Kegiatan</span>
                                <div class="w-10 h-10"></div>
                            </div>

                            <div class="flex flex-col items-center text-center">
                                <div class="w-24 h-24 bg-[#EFF6FF] rounded-[2rem] flex items-center justify-center text-5xl mb-6 shadow-inner" x-text="form.emoji"></div>
                                <h1 class="text-[#1E3A8A] text-2xl font-extrabold leading-tight mb-2" x-text="form.title || 'Judul Kegiatan'"></h1>
                                <div class="flex items-center gap-1.5 text-gray-400 font-bold text-xs uppercase tracking-wide">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span x-text="form.location || 'Lokasi Belum Diatur'"></span>
                                </div>
                            </div>

                            <div class="mt-10 bg-gray-50 rounded-[2rem] p-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Waktu</span>
                                    <span class="text-[#1E3A8A] text-xs font-extrabold" x-text="new Date(form.starts_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'short'}) + ', ' + new Date(form.starts_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})"></span>
                                </div>
                                <div class="h-px bg-gray-200"></div>
                                <div class="flex flex-col gap-2">
                                    <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Keterangan</span>
                                    <div class="text-[#1E3A8A] text-sm leading-relaxed whitespace-pre-wrap text-wrap break-words" x-text="form.description || 'Tidak ada deskripsi tambahan.'"></div>
                                </div>
                            </div>

                            <div class="mt-8 pb-10">
                                <button type="button" class="w-full bg-[#2563EB] text-white font-extrabold py-5 rounded-3xl shadow-xl shadow-blue-100 uppercase tracking-widest text-sm">Hadir Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
