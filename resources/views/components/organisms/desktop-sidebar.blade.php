@props(['handdrawn' => false])
<aside class="app-sidebar hidden lg:flex {{ $handdrawn ? 'hd-dashed' : '' }}">
    <div class="flex flex-col h-full grow">
        {{-- Brand / Logo area --}}
        <div class="p-8 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white flex items-center justify-center shrink-0 p-1 {{ $handdrawn ? 'hd-wobbly-md border-hd-ink' : 'rounded-xl shadow-md border border-gray-100' }}">
                    <img src="/logo/KDCW.png" alt="KeDai Computerworks" class="w-full h-full object-contain">
                </div>
                <div class="flex flex-col">
                    <span class="font-rockwell text-lg leading-tight text-navy">KeDai</span>
                    <span class="font-staccato text-sm -mt-0.5 text-primary">Computerworks</span>
                </div>
            </div>
        </div>

        {{-- Main Nav --}}
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto scrollbar-hide">
            {{-- Beranda --}}
            <a href="{{ route('home') }}" 
               class="flex items-center gap-3 px-4 py-3 transition-all duration-200 
               {{ request()->routeIs('home') ? ($handdrawn ? 'bg-blue-50 text-primary hd-wobbly-md' : 'bg-bg-soft text-primary rounded-2xl') : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                <svg class="w-6 h-6" fill="{{ request()->routeIs('home') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-5h4v5h4a1 1 0 001-1V10"/>
                </svg>
                <span class="text-sm font-semibold">Beranda</span>
            </a>

            {{-- Kegiatan --}}
            <a href="{{ route('pesanan') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 
               {{ request()->routeIs('pesanan') ? 'bg-bg-soft text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                <span class="text-sm font-semibold">Kegiatan</span>
            </a>

            {{-- Berita --}}
            <a href="{{ route('news.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 
               {{ request()->routeIs('news.index') ? 'bg-bg-soft text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="text-sm font-semibold">Berita</span>
            </a>

            {{-- Direktori --}}
            <a href="{{ route('direktori') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 
               {{ request()->routeIs('direktori') ? 'bg-bg-soft text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                </svg>
                <span class="text-sm font-semibold">Direktori</span>
            </a>

            {{-- Profil --}}
            <a href="{{ route('profil') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 
               {{ request()->routeIs('profil') ? 'bg-bg-soft text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="text-sm font-semibold">Profil</span>
            </a>

            {{-- Admin Section --}}
            @if(auth()->user()?->isAdmin())
                <div class="mt-8 mb-2 px-4">
                    <div class="hd-scribble-divider opacity-20 mb-4"></div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-4 {{ $handdrawn ? 'font-hand' : '' }}">Manajemen Admin</p>
                </div>

                {{-- Kelola Kegiatan --}}
                <a href="{{ route('admin.activities.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 transition-all duration-200 
                   {{ request()->routeIs('admin.activities.*') ? ($handdrawn ? 'bg-blue-50 text-primary hd-wobbly-md' : 'bg-bg-soft text-primary rounded-2xl') : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <span class="text-sm font-semibold">Kelola Kegiatan</span>
                </a>

                {{-- Kelola Berita --}}
                <a href="{{ route('admin.news.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 transition-all duration-200 
                   {{ request()->routeIs('admin.news.*') ? ($handdrawn ? 'bg-blue-50 text-primary hd-wobbly-md' : 'bg-bg-soft text-primary rounded-2xl') : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                    </svg>
                    <span class="text-sm font-semibold">Kelola Berita</span>
                </a>
            @endif
        </nav>

        {{-- Footer area / Logout button maybe? --}}
        <div class="px-4 py-8 mt-auto border-t border-gray-50">
            <div class="flex items-center gap-3 px-4 py-3">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-primary">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="text-sm font-bold text-navy truncate">{{ auth()->user()->name ?? 'KeDai User' }}</span>
                    <span class="text-xs text-gray-400 truncate">{{ auth()->user()->email ?? 'user@kedaicomputerworks.com' }}</span>
                </div>
            </div>
        </div>
    </div>
</aside>
