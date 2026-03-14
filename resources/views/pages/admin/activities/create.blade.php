<x-app-layout>

    {{-- Header --}}
    <div class="bg-[#1E3A8A] px-5 pt-12 pb-7 relative overflow-hidden rounded-b-[2rem]">
        <div class="absolute -top-6 -right-6 w-36 h-36 rounded-full border-[24px] border-white/10 pointer-events-none"></div>

        <a href="{{ route('admin.activities.index') }}"
           class="relative z-10 inline-flex items-center gap-1.5 text-white/60 hover:text-white text-sm font-semibold mb-4 active:opacity-60 transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kelola Kegiatan
        </a>

        <div class="relative z-10 inline-flex items-center gap-1.5 bg-white/20 rounded-xl px-3 py-1.5 mb-3">
            <div class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></div>
            <span class="text-white text-xs font-bold tracking-wide">MODE ADMIN</span>
        </div>

        <h1 class="relative z-10 text-white text-xl font-extrabold">Tambah Kegiatan</h1>
        <p class="relative z-10 text-blue-200 text-sm mt-1">Isi detail kegiatan baru di bawah ini</p>
    </div>

    {{-- Form --}}
    <div class="px-5 py-5">
        <form method="POST" action="{{ route('admin.activities.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            {{-- Thumbnail Image --}}
            <div class="space-y-1.5" x-data="{ preview: null }">
                <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Thumbnail / Poster</label>
                <div class="relative group">
                    <input type="file" name="image" id="image" class="hidden" accept="image/*"
                        @change="let file = $event.target.files[0]; if(file){ let reader = new FileReader(); reader.onload = (e) => { preview = e.target.result }; reader.readAsDataURL(file); }">
                    <label for="image" class="flex flex-col items-center justify-center w-full h-40 bg-[#EFF6FF] border-2 border-dashed border-blue-200 rounded-3xl cursor-pointer hover:bg-blue-50 transition-all overflow-hidden relative">
                        <template x-if="!preview">
                            <div class="flex flex-col items-center text-center px-4">
                                <svg class="w-10 h-10 text-[#2563EB] mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15m4.5-9l3 3m0 0l3-3m-3 3v12.75"/>
                                </svg>
                                <p class="text-[#2563EB] text-xs font-bold">Tap untuk upload gambar</p>
                                <p class="text-gray-400 text-[10px] mt-1">Format: JPG, PNG, WEBP (Maks. 2MB)</p>
                            </div>
                        </template>
                        <template x-if="preview">
                            <img :src="preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="preview">
                            <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <p class="text-white text-xs font-bold">Ganti Gambar</p>
                            </div>
                        </template>
                    </label>
                </div>
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Judul --}}
            <div class="space-y-1.5">
                <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Judul Kegiatan <span class="text-red-400">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Gathering Anggota 2025"
                    class="w-full px-4 py-3 bg-[#EFF6FF] border-2 border-transparent rounded-2xl text-[#1E3A8A] text-sm font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:border-[#2563EB] transition-all duration-200 @error('title') border-red-400 bg-red-50 @enderror">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Emoji --}}
            <div class="space-y-1.5">
                <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Emoji</label>
                <div class="flex gap-2 items-center">
                    <input type="text" name="emoji" value="{{ old('emoji') }}" maxlength="10" id="emoji-input"
                        placeholder="📍"
                        class="w-20 px-4 py-3 bg-[#EFF6FF] border-2 border-transparent rounded-2xl text-[#1E3A8A] text-xl text-center focus:outline-none focus:border-[#2563EB] transition-all duration-200">
                    <div class="flex gap-2 flex-wrap">
                        @foreach(['🎉','☕','🏆','📚','🎨','🎤','🏋️','🌿','💼','🎯'] as $em)
                        <button type="button" onclick="document.getElementById('emoji-input').value='{{ $em }}'"
                            class="text-xl w-10 h-10 bg-[#EFF6FF] rounded-xl hover:bg-blue-100 active:scale-90 transition-all">{{ $em }}</button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="space-y-1.5">
                <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Deskripsi</label>
                <textarea name="description" rows="3" placeholder="Deskripsi singkat kegiatan…"
                    class="w-full px-4 py-3 bg-[#EFF6FF] border-2 border-transparent rounded-2xl text-[#1E3A8A] text-sm font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:border-[#2563EB] transition-all duration-200 resize-none">{{ old('description') }}</textarea>
            </div>

            {{-- Lokasi --}}
            <div class="space-y-1.5">
                <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Lokasi</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="Contoh: Aula Utama Gedung A"
                        class="w-full pl-10 pr-4 py-3 bg-[#EFF6FF] border-2 border-transparent rounded-2xl text-[#1E3A8A] text-sm font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:border-[#2563EB] transition-all duration-200">
                </div>
            </div>

            {{-- Tanggal & Waktu --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Mulai <span class="text-red-400">*</span></label>
                    <input type="datetime-local" name="starts_at" value="{{ old('starts_at') }}"
                        class="w-full px-4 py-3 bg-[#EFF6FF] border-2 border-transparent rounded-2xl text-[#1E3A8A] text-sm font-medium focus:outline-none focus:border-[#2563EB] transition-all duration-200 @error('starts_at') border-red-400 bg-red-50 @enderror">
                    @error('starts_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Selesai <span class="text-red-400">*</span></label>
                    <input type="datetime-local" name="ends_at" value="{{ old('ends_at') }}"
                        class="w-full px-4 py-3 bg-[#EFF6FF] border-2 border-transparent rounded-2xl text-[#1E3A8A] text-sm font-medium focus:outline-none focus:border-[#2563EB] transition-all duration-200 @error('ends_at') border-red-400 bg-red-50 @enderror">
                    @error('ends_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Status --}}
            <div class="space-y-1.5">
                <label class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">Status <span class="text-red-400">*</span></label>
                <div class="flex gap-2">
                    @foreach(['upcoming' => '📅 Akan Datang', 'open' => '✅ Buka', 'closed' => '🔒 Tutup'] as $val => $label)
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="status" value="{{ $val }}" class="hidden peer"
                            {{ old('status', 'upcoming') === $val ? 'checked' : '' }}>
                        <div class="text-center py-2.5 px-2 rounded-2xl border-2 border-transparent bg-[#EFF6FF] text-[#1E3A8A] text-xs font-semibold
                            peer-checked:bg-[#2563EB] peer-checked:text-white peer-checked:border-[#2563EB] transition-all duration-200">
                            {{ $label }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Submit --}}
            <div class="pt-2">
                <button type="submit"
                    class="w-full bg-[#2563EB] text-white font-extrabold py-4 rounded-2xl shadow-lg shadow-blue-200 active:scale-[0.97] transition-all duration-200 text-sm">
                    Simpan Kegiatan
                </button>
            </div>

        </form>
    </div>

</x-app-layout>
