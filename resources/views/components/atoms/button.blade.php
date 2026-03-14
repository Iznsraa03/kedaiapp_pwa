@props([
    'variant'   => 'primary',
    'size'      => 'md',
    'type'      => 'button',
    'full'      => false,
    'handdrawn' => false,
    'href'      => null,
])

@php
    $base = 'inline-flex items-center justify-center gap-2 font-semibold transition-all duration-200 select-none';

    if ($handdrawn) {
        $base .= ' hd-wobbly-md hd-shadow border-[#2d2d2d] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[2px_2px_0px_0px_#2d2d2d]';
    } else {
        $base .= ' rounded-2xl active:scale-[0.97]';
    }

    $variants = [
        'primary'   => $handdrawn ? 'bg-[#2563EB] text-white' : 'bg-[#2563EB] text-white shadow-lg shadow-blue-200 hover:bg-blue-700',
        'secondary' => $handdrawn ? 'bg-white text-[#2563EB]' : 'bg-[#EFF6FF] text-[#2563EB] hover:bg-blue-100',
        'danger'    => $handdrawn ? 'bg-red-50 text-red-500' : 'bg-red-50 text-red-500 hover:bg-red-100',
        'ghost'     => 'text-[#2563EB] hover:bg-[#EFF6FF]',
    ];

    $sizes = [
        'sm' => 'px-4 py-2 text-xs',
        'md' => 'px-5 py-3 text-sm',
        'lg' => 'px-6 py-4 text-sm',
    ];

    $isFull = filter_var($full, FILTER_VALIDATE_BOOL);
    $classes = $base
        . ' ' . ($variants[(string) $variant] ?? $variants['primary'])
        . ' ' . ($sizes[(string) $size] ?? $sizes['md'])
        . ($isFull ? ' w-full' : '');
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
