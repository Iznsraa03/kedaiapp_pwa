<x-app-layout>

    {{-- Header --}}
    <div class="bg-primary px-5 pt-12 pb-6 rounded-b-3xl">
        <div class="flex items-center gap-3">
            <a href="{{ route('profil') }}"
               class="w-9 h-9 bg-white/20 rounded-2xl flex items-center justify-center active:scale-90 transition-transform duration-150">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-white text-base font-bold leading-none">Edit Profil</h1>
                <p class="text-blue-200 text-xs mt-0.5">Perbarui data pribadi kamu</p>
            </div>
        </div>
    </div>

    <div class="px-5 py-5">

        {{-- Success Message --}}
        @if(session('success'))
        <div class="bg-green-50 border border-green-100 text-green-600 text-sm font-medium px-4 py-3 rounded-2xl mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('profil.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="bg-white border border-gray-100 rounded-2xl px-4 py-3 shadow-sm">
                <label class="text-[#1E3A8A] text-xs font-bold uppercase tracking-wide mb-1.5 block">Nama Lengkap</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    placeholder="Masukkan nama lengkap"
                    class="w-full text-sm text-gray-700 font-medium placeholder-gray-300 border-0 outline-none focus:ring-0 p-0 bg-transparent"
                    required
                >
                @error('name')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email (read only) --}}
            <div class="bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 shadow-sm">
                <label class="text-gray-400 text-xs font-bold uppercase tracking-wide mb-1.5 block">Email</label>
                <input
                    type="email"
                    value="{{ $user->email }}"
                    class="w-full text-sm text-gray-400 font-medium border-0 outline-none focus:ring-0 p-0 bg-transparent cursor-not-allowed"
                    disabled
                >
                <p class="text-gray-300 text-[10px] mt-1">Email tidak dapat diubah</p>
            </div>

            {{-- NRA (read only) --}}
            <div class="bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 shadow-sm">
                <label class="text-gray-400 text-xs font-bold uppercase tracking-wide mb-1.5 block">NRA</label>
                <input
                    type="text"
                    value="{{ $user->nra }}"
                    class="w-full text-sm text-gray-400 font-medium border-0 outline-none focus:ring-0 p-0 bg-transparent cursor-not-allowed"
                    disabled
                >
                <p class="text-gray-300 text-[10px] mt-1">NRA tidak dapat diubah</p>
            </div>

            {{-- No. HP --}}
            <div class="bg-white border border-gray-100 rounded-2xl px-4 py-3 shadow-sm">
                <label class="text-[#1E3A8A] text-xs font-bold uppercase tracking-wide mb-1.5 block">No. HP / WhatsApp</label>
                <input
                    type="tel"
                    name="phone"
                    value="{{ old('phone', $user->phone) }}"
                    placeholder="Contoh: 08123456789"
                    class="w-full text-sm text-gray-700 font-medium placeholder-gray-300 border-0 outline-none focus:ring-0 p-0 bg-transparent"
                >
                @error('phone')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat --}}
            <div class="bg-white border border-gray-100 rounded-2xl px-4 py-3 shadow-sm">
                <label class="text-[#1E3A8A] text-xs font-bold uppercase tracking-wide mb-1.5 block">Alamat</label>
                <textarea
                    name="address"
                    rows="3"
                    placeholder="Masukkan alamat lengkap kamu"
                    class="w-full text-sm text-gray-700 font-medium placeholder-gray-300 border-0 outline-none focus:ring-0 p-0 bg-transparent resize-none"
                >{{ old('address', $user->address) }}</textarea>
                @error('address')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <button
                type="submit"
                class="w-full bg-[#2563EB] text-white font-bold text-sm py-4 rounded-2xl shadow-lg shadow-blue-200 active:scale-[0.98] transition-transform duration-150 mt-2"
            >
                Simpan Perubahan
            </button>

        </form>

    </div>

</x-app-layout>
