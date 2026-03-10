@props([
    'variant' => 'primary',   // primary | secondary | danger | ghost
    'size'    => 'md',        // sm | md | lg
    'type'    => 'button',
    'full'    => false,
])

@php
    $base = 'inline-flex items-center justify-center gap-2 font-semibold rounded-2xl transition-all duration-200 active:scale-[0.97] select-none';

    $variants = [
        'primary'   => 'bg-[#2563EB] text-white shadow-lg shadow-blue-200 hover:bg-blue-700',
        'secondary' => 'bg-[#EFF6FF] text-[#2563EB] hover:bg-blue-100',
        'danger'    => 'bg-red-50 text-red-500 hover:bg-red-100',
        'ghost'     => 'text-[#2563EB] hover:bg-[#EFF6FF]',
    ];

    $sizes = [
        'sm' => 'px-4 py-2 text-xs',
        'md' => 'px-5 py-3 text-sm',
        'lg' => 'px-6 py-4 text-sm',
    ];

    $classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']) . ($full ? ' w-full' : '');
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
