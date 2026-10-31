@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center w-full rounded-xl px-4 py-2.5 text-start text-sm font-bold text-blue-700 bg-blue-50 border border-blue-100 transition duration-150 ease-in-out'
            : 'flex items-center w-full rounded-xl px-4 py-2.5 text-start text-sm font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
