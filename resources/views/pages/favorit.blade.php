<x-app-layout>

    {{-- Header --}}
    <div class="px-5 pt-12 pb-6 bg-[#1E3A8A] hd-wobbly-lg mt-2 mx-2">
        <h1 class="text-white text-xl font-bold">Favorit Saya</h1>
        <p class="text-blue-200 text-sm mt-1">Menu yang kamu suka</p>
    </div>

    <div class="px-5 py-5 space-y-3">

        @php
            $favorits = [
                ['nama' => 'Kopi Susu Gula Aren', 'harga' => 'Rp 18.000', 'rating' => '4.8', 'emoji' => '☕', 'terjual' => '1.2k terjual'],
                ['nama' => 'Matcha Latte', 'harga' => 'Rp 22.000', 'rating' => '4.7', 'emoji' => '🍵', 'terjual' => '890 terjual'],
                ['nama' => 'Nasi Goreng Spesial', 'harga' => 'Rp 25.000', 'rating' => '4.9', 'emoji' => '🍳', 'terjual' => '2.1k terjual'],
                ['nama' => 'Snack Box Mix', 'harga' => 'Rp 15.000', 'rating' => '4.6', 'emoji' => '🍱', 'terjual' => '670 terjual'],
            ];
        @endphp

        @foreach($favorits as $item)
        <div class="bg-white hd-card p-4 flex items-center gap-4 active:scale-[0.98] transition-transform duration-150 border-none">
            <div class="w-16 h-16 bg-blue-50 hd-wobbly-md flex items-center justify-center text-3xl flex-shrink-0 border border-hd-ink/10">
                {{ $item['emoji'] }}
            </div>
            <div class="flex-1">
                <p class="text-[#1E3A8A] font-bold text-sm">{{ $item['nama'] }}</p>
                <p class="text-gray-400 text-xs mt-0.5">{{ $item['terjual'] }}</p>
                <div class="flex items-center gap-1 mt-1">
                    <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-gray-400 text-xs font-bold">{{ $item['rating'] }}</span>
                </div>
            </div>
            <div class="flex flex-col items-end gap-2">
                <button class="text-red-400 active:scale-95 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
                <p class="text-[#2563EB] font-extrabold text-sm">{{ $item['harga'] }}</p>
            </div>
        </div>
        @endforeach

    </div>

</x-app-layout>
