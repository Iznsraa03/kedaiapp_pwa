@props([
    'title'    => '',
    'subtitle' => '',
    'back'     => null,   // route name untuk back button
])

<div class="bg-[#2563EB] px-5 pt-12 pb-6 rounded-b-3xl relative overflow-hidden">
    {{-- Dekorasi --}}
    <div class="absolute -top-6 -right-6 w-32 h-32 rounded-full border-[20px] border-white/10 pointer-events-none"></div>
    <div class="absolute -bottom-4 -left-4 w-20 h-20 rounded-full border-[14px] border-white/10 pointer-events-none"></div>

    @if($back)
        <a href="{{ route($back) }}" class="relative z-10 inline-flex items-center gap-1.5 text-white/70 hover:text-white text-sm font-semibold mb-4 active:opacity-60 transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
    @endif

    <div class="relative z-10">
        @if($title)
            <h1 class="text-white text-xl font-bold">{{ $title }}</h1>
        @endif
        @if($subtitle)
            <p class="text-blue-200 text-sm mt-1">{{ $subtitle }}</p>
        @endif
        {{ $slot }}
    </div>
</div>
