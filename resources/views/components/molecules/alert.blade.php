@props([
    'type'      => 'error',
    'handdrawn' => false,
])

@php
    $styles = [
        'error'   => 'bg-red-50 border-red-100',
        'success' => 'bg-green-50 border-green-100',
        'info'    => 'bg-[#EFF6FF] border-blue-100',
    ];
    $iconStyles = [
        'error'   => 'bg-red-100 text-red-500',
        'success' => 'bg-green-100 text-green-500',
        'info'    => 'bg-blue-100 text-[#2563EB]',
    ];
    $s = $styles[$type] ?? $styles['error'];
    $i = $iconStyles[$type] ?? $iconStyles['error'];
@endphp

<div {{ $attributes->merge(['class' => "flex items-start gap-3 border px-4 py-3 " . ($handdrawn ? 'bg-white hd-card' : "rounded-2xl $s")]) }}>
    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 mt-0.5 {{ $i }}">
        @if($type === 'error')
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
            </svg>
        @elseif($type === 'success')
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
            </svg>
        @else
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
            </svg>
        @endif
    </div>
    <div class="space-y-0.5">
        {{ $slot }}
    </div>
</div>
