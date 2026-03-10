@props([
    'color' => 'blue', // blue | green | yellow | red | gray
])

@php
    $colors = [
        'blue'   => 'bg-[#EFF6FF] text-[#2563EB]',
        'green'  => 'bg-green-100 text-green-700',
        'yellow' => 'bg-yellow-100 text-yellow-700',
        'red'    => 'bg-red-100 text-red-500',
        'gray'   => 'bg-gray-100 text-gray-500',
    ];
    $cls = $colors[$color] ?? $colors['blue'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-3 py-1 rounded-xl text-xs font-semibold $cls"]) }}>
    {{ $slot }}
</span>
