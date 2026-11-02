@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center w-full rounded-xl px-4 py-2.5 text-start text-sm font-bold text-white bg-gradient-to-r from-blue-600/40 to-indigo-600/40 border border-cyan-300/30 transition duration-150 ease-in-out'
            : 'flex items-center w-full rounded-xl px-4 py-2.5 text-start text-sm font-semibold text-blue-100/80 hover:text-white hover:bg-white/10 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
