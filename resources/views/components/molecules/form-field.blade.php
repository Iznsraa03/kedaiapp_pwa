@props([
    'label'   => '',
    'name'    => '',
    'type'    => 'text',
    'icon'    => null,
    'error'   => false,
    'toggle'  => false,   // true = tambahkan toggle show/hide password
    'eyeId'   => null,
])

<div {{ $attributes->merge(['class' => 'space-y-2']) }}>
    @if($label)
        <label for="{{ $name }}" class="block text-[#1E3A8A] text-xs font-bold uppercase tracking-widest">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        @if($icon)
            <span class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none text-blue-300">
                {!! $icon !!}
            </span>
        @endif

        <x-atoms.input
            :id="$name"
            :name="$name"
            :type="$type"
            :error="$error"
            :class="$icon ? 'pl-12' : ''"
            :class="$toggle ? 'pr-12' : ''"
            {{ $attributes->only(['placeholder', 'value', 'autocomplete', 'required']) }}
        />

        @if($toggle && $eyeId)
            <button type="button" onclick="togglePass('{{ $name }}','{{ $eyeId }}')"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-blue-300 hover:text-[#2563EB] active:scale-90 transition-all">
                <svg id="{{ $eyeId }}" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </button>
        @endif
    </div>
</div>
