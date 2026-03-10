<nav class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-md bg-white border-t border-gray-100 shadow-lg pb-safe z-50">
    <div class="flex items-center justify-around px-2 pt-2 pb-3">

        {{-- Beranda --}}
        <a href="{{ route('home') }}"
           class="flex flex-col items-center gap-1 px-4 py-1 rounded-2xl transition-all duration-200
                  {{ request()->routeIs('home') ? 'nav-active' : 'text-gray-400 hover:text-blue-500' }}">
            <svg class="w-6 h-6 transition-colors duration-200" fill="{{ request()->routeIs('home') ? '#2563EB' : 'none' }}" viewBox="0 0 24 24" stroke="{{ request()->routeIs('home') ? '#2563EB' : 'currentColor' }}" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-5h4v5h4a1 1 0 001-1V10"/>
            </svg>
            <span class="text-[10px] font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-[#2563EB]' : 'text-gray-400' }}">Beranda</span>
        </a>

        {{-- Kegiatan --}}
        <a href="{{ route('pesanan') }}"
           class="flex flex-col items-center gap-1 px-4 py-1 rounded-2xl transition-all duration-200
                  {{ request()->routeIs('pesanan') ? 'nav-active' : 'text-gray-400 hover:text-blue-500' }}">
            <svg class="w-6 h-6 transition-colors duration-200" fill="{{ request()->routeIs('pesanan') ? '#EFF6FF' : 'none' }}" viewBox="0 0 24 24" stroke="{{ request()->routeIs('pesanan') ? '#2563EB' : 'currentColor' }}" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            <span class="text-[10px] font-medium transition-colors duration-200 {{ request()->routeIs('pesanan') ? 'text-[#2563EB]' : 'text-gray-400' }}">Kegiatan</span>
        </a>

        {{-- Direktori --}}
        <a href="{{ route('direktori') }}"
           class="flex flex-col items-center gap-1 px-4 py-1 rounded-2xl transition-all duration-200
                  {{ request()->routeIs('direktori') ? 'nav-active' : 'text-gray-400 hover:text-blue-500' }}">
            <svg class="w-6 h-6 transition-colors duration-200" fill="{{ request()->routeIs('direktori') ? '#EFF6FF' : 'none' }}" viewBox="0 0 24 24" stroke="{{ request()->routeIs('direktori') ? '#2563EB' : 'currentColor' }}" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
            </svg>
            <span class="text-[10px] font-medium transition-colors duration-200 {{ request()->routeIs('direktori') ? 'text-[#2563EB]' : 'text-gray-400' }}">Direktori</span>
        </a>

        {{-- Profil --}}
        <a href="{{ route('profil') }}"
           class="flex flex-col items-center gap-1 px-4 py-1 rounded-2xl transition-all duration-200
                  {{ request()->routeIs('profil') ? 'nav-active' : 'text-gray-400 hover:text-blue-500' }}">
            <svg class="w-6 h-6 transition-colors duration-200" fill="{{ request()->routeIs('profil') ? '#EFF6FF' : 'none' }}" viewBox="0 0 24 24" stroke="{{ request()->routeIs('profil') ? '#2563EB' : 'currentColor' }}" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="text-[10px] font-medium transition-colors duration-200 {{ request()->routeIs('profil') ? 'text-[#2563EB]' : 'text-gray-400' }}">Profil</span>
        </a>

    </div>
</nav>
