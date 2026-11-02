@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3.5 py-2 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-500/35 to-indigo-500/35 border border-cyan-300/30 shadow-sm shadow-blue-950/30 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-3.5 py-2 rounded-xl text-sm font-semibold text-blue-100/80 hover:text-white hover:bg-white/10 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
