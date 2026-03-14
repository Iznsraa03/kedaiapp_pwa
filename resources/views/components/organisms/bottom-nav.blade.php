@props(['handdrawn' => false])
<nav class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-md bg-white border-t border-gray-100 z-50 pb-safe {{ $handdrawn ? 'hd-card m-2 w-[calc(100%-1rem)] !bottom-2 !left-0 !translate-x-0' : 'shadow-lg' }}">
    <div class="flex items-center justify-start px-2 pt-2 pb-3 overflow-x-auto scrollbar-hide gap-1">
        {{-- Beranda --}}
        <a href="{{ route('home') }}"
           class="flex flex-col items-center gap-1 px-4 py-1 transition-all duration-200 flex-shrink-0
                  {{ request()->routeIs('home') ? ($handdrawn ? 'nav-active bg-blue-50 hd-wobbly-md' : 'nav-active rounded-2xl') : 'text-gray-400 hover:text-blue-500' }}">
            <svg class="w-6 h-6 transition-colors duration-200" fill="{{ request()->routeIs('home') ? '#2563EB' : 'none' }}" viewBox="0 0 24 24" stroke="{{ request()->routeIs('home') ? '#2563EB' : 'currentColor' }}" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-5h4v5h4a1 1 0 001-1V10"/>
            </svg>
            <span class="text-[10px] font-bold transition-colors duration-200 {{ request()->routeIs('home') ? 'text-[#2563EB]' : 'text-gray-400' }}">Beranda</span>
        </a>

        {{-- Kegiatan (Publik) --}}
        <a href="{{ route('pesanan') }}"
           class="flex flex-col items-center gap-1 px-4 py-1 transition-all duration-200 flex-shrink-0
                  {{ request()->routeIs('pesanan') ? ($handdrawn ? 'nav-active bg-blue-50 hd-wobbly-md' : 'nav-active rounded-2xl') : 'text-gray-400 hover:text-blue-500' }}">
            <svg class="w-6 h-6 transition-colors duration-200" fill="{{ request()->routeIs('pesanan') ? '#EFF6FF' : 'none' }}" viewBox="0 0 24 24" stroke="{{ request()->routeIs('pesanan') ? '#2563EB' : 'currentColor' }}" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            <span class="text-[10px] font-bold transition-colors duration-200 {{ request()->routeIs('pesanan') ? 'text-[#2563EB]' : 'text-gray-400' }}">Kegiatan</span>
        </a>

        {{-- Berita (Publik) --}}
        <a href="{{ route('news.index') }}"
           class="flex flex-col items-center gap-1 px-4 py-1 transition-all duration-200 flex-shrink-0
                  {{ request()->routeIs('news.index') ? ($handdrawn ? 'nav-active bg-blue-50 hd-wobbly-md' : 'nav-active rounded-2xl') : 'text-gray-400 hover:text-blue-500' }}">
            <svg class="w-6 h-6 transition-colors duration-200" fill="{{ request()->routeIs('news.index') ? '#EFF6FF' : 'none' }}" viewBox="0 0 24 24" stroke="{{ request()->routeIs('news.index') ? '#2563EB' : 'currentColor' }}" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="text-[10px] font-bold transition-colors duration-200 {{ request()->routeIs('news.index') ? 'text-[#2563EB]' : 'text-gray-400' }}">Berita</span>
        </a>

        {{-- Admin Section (Management) --}}
        @if(auth()->user()?->isAdmin())
            {{-- Management Divider Line --}}
            <div class="w-px h-8 bg-gray-100 flex-shrink-0 mx-1"></div>

            {{-- Kelola Kegiatan --}}
            <a href="{{ route('admin.activities.index') }}"
               class="flex flex-col items-center gap-1 px-4 py-1 transition-all duration-200 flex-shrink-0
                      {{ request()->routeIs('admin.activities.*') ? ($handdrawn ? 'nav-active bg-blue-50 hd-wobbly-md' : 'nav-active rounded-2xl') : 'text-gray-400 hover:text-blue-500' }}">
                <svg class="w-6 h-6 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <span class="text-[10px] font-bold">M-Kegiatan</span>
            </a>

            {{-- Kelola Berita --}}
            <a href="{{ route('admin.news.index') }}"
               class="flex flex-col items-center gap-1 px-4 py-1 transition-all duration-200 flex-shrink-0
                      {{ request()->routeIs('admin.news.*') ? ($handdrawn ? 'nav-active bg-blue-50 hd-wobbly-md' : 'nav-active rounded-2xl') : 'text-gray-400 hover:text-blue-500' }}">
                <svg class="w-6 h-6 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                </svg>
                <span class="text-[10px] font-bold">M-Berita</span>
            </a>
        @endif

        <div class="w-px h-8 bg-gray-100 flex-shrink-0 mx-1"></div>

        {{-- Direktori --}}
        <a href="{{ route('direktori') }}"
           class="flex flex-col items-center gap-1 px-4 py-1 transition-all duration-200 flex-shrink-0
                  {{ request()->routeIs('direktori') ? ($handdrawn ? 'nav-active bg-blue-50 hd-wobbly-md' : 'nav-active rounded-2xl') : 'text-gray-400 hover:text-blue-500' }}">
            <svg class="w-6 h-6 transition-colors duration-200" fill="{{ request()->routeIs('direktori') ? '#EFF6FF' : 'none' }}" viewBox="0 0 24 24" stroke="{{ request()->routeIs('direktori') ? '#2563EB' : 'currentColor' }}" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
            </svg>
            <span class="text-[10px] font-bold transition-colors duration-200 {{ request()->routeIs('direktori') ? 'text-[#2563EB]' : 'text-gray-400' }}">Direktori</span>
        </a>

        {{-- Profil --}}
        <a href="{{ route('profil') }}"
           class="flex flex-col items-center gap-1 px-4 py-1 transition-all duration-200 flex-shrink-0
                  {{ request()->routeIs('profil') ? ($handdrawn ? 'nav-active bg-blue-50 hd-wobbly-md' : 'nav-active rounded-2xl') : 'text-gray-400 hover:text-blue-500' }}">
            <svg class="w-6 h-6 transition-colors duration-200" fill="{{ request()->routeIs('profil') ? '#EFF6FF' : 'none' }}" viewBox="0 0 24 24" stroke="{{ request()->routeIs('profil') ? '#2563EB' : 'currentColor' }}" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="text-[10px] font-bold transition-colors duration-200 {{ request()->routeIs('profil') ? 'text-[#2563EB]' : 'text-gray-400' }}">Profil</span>
        </a>
    </div>

    </div>
</nav>
