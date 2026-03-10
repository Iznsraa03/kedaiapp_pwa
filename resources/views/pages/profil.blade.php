<x-app-layout>

    {{-- Header --}}
    <div class="bg-primary px-5 pt-12 pb-10 rounded-b-3xl">
        <div class="flex flex-col items-center gap-3">
            <div class="w-20 h-20 bg-white/20 rounded-3xl flex items-center justify-center text-4xl">
                👤
            </div>
            <div class="text-center">
                <h1 class="text-white text-lg font-bold">{{ Auth::user()->name }}</h1>
                <p class="text-blue-200 text-xs font-medium mt-0.5">NRA: {{ Auth::user()->nra }}</p>
                <p class="text-blue-200 text-sm">{{ Auth::user()->email }}</p>
                @if(Auth::user()->phone)
                <p class="text-blue-200 text-xs mt-0.5">📞 {{ Auth::user()->phone }}</p>
                @endif
            </div>
            <div class="flex gap-6 mt-2">
                <div class="text-center">
                    <p class="text-white font-bold text-lg">12</p>
                    <p class="text-blue-200 text-xs">Pesanan</p>
                </div>
                <div class="w-px bg-white/20"></div>
                <div class="text-center">
                    <p class="text-white font-bold text-lg">4</p>
                    <p class="text-blue-200 text-xs">Favorit</p>
                </div>
                <div class="w-px bg-white/20"></div>
                <div class="text-center">
                    <p class="text-white font-bold text-lg">2</p>
                    <p class="text-blue-200 text-xs">Ulasan</p>
                </div>
            </div>
        </div>
    </div>

    <div class="px-5 py-5 space-y-3">

        {{-- QR Card Presensi --}}
    <x-molecules.user-qr-card :user="$user" />

    {{-- Admin Link --}}
    @if(Auth::user()->role === 'admin')
    <a href="{{ route('admin.activities.index') }}"
       class="flex items-center gap-3 bg-[#EFF6FF] border border-blue-100 rounded-2xl p-4 shadow-sm active:scale-[0.98] transition-transform duration-150">
        <div class="w-11 h-11 bg-[#2563EB] rounded-2xl flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
            </svg>
        </div>
        <div class="flex-1">
            <p class="text-[#1E3A8A] font-bold text-sm">Panel Admin</p>
            <p class="text-gray-400 text-xs mt-0.5">Kelola kegiatan & presensi</p>
        </div>
        <svg class="w-4 h-4 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
    @endif

    {{-- Menu Profil --}}
        @php
            $menus = [
                ['icon' => '👤', 'label' => 'Edit Profil', 'desc' => 'Ubah data pribadi kamu'],
                ['icon' => '📍', 'label' => 'Alamat Saya', 'desc' => 'Kelola alamat pengiriman'],
                ['icon' => '💳', 'label' => 'Metode Pembayaran', 'desc' => 'Kartu & dompet digital'],
                ['icon' => '🔔', 'label' => 'Notifikasi', 'desc' => 'Atur preferensi notifikasi'],
                ['icon' => '🛡️', 'label' => 'Keamanan', 'desc' => 'Password & keamanan akun'],
                ['icon' => '❓', 'label' => 'Bantuan', 'desc' => 'Pusat bantuan & FAQ'],
            ];
        @endphp

        @foreach($menus as $menu)
        <div class="bg-white border border-gray-100 rounded-2xl p-4 flex items-center gap-4 shadow-sm active:scale-[0.98] transition-transform duration-150 cursor-pointer">
            <div class="w-11 h-11 bg-[#EFF6FF] rounded-2xl flex items-center justify-center text-xl flex-shrink-0">
                {{ $menu['icon'] }}
            </div>
            <div class="flex-1">
                <p class="text-[#1E3A8A] font-semibold text-sm">{{ $menu['label'] }}</p>
                <p class="text-gray-400 text-xs mt-0.5">{{ $menu['desc'] }}</p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
        @endforeach

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full bg-red-50 text-red-500 font-semibold py-4 rounded-2xl flex items-center justify-center gap-2 active:scale-[0.98] transition-transform duration-150 mt-2 hover:bg-red-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Keluar
            </button>
        </form>

    </div>

</x-app-layout>
