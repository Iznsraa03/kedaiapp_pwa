@props([
    'error' => false,
])

<input {{ $attributes->merge([
    'class' => 'w-full px-4 py-3.5 bg-[#EFF6FF] border-2 rounded-2xl text-[#1E3A8A] text-sm font-medium placeholder:text-gray-400 placeholder:font-normal focus:outline-none focus:border-[#2563EB] focus:shadow-[0_0_0_3px_rgba(37,99,235,0.12)] transition-all duration-200 ' . ($error ? 'border-red-300' : 'border-transparent'),
]) }}>
