@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-[calc(100%-2rem)] mx-auto my-2 rounded-xl px-4 py-3 text-start text-base font-bold text-blue-700 bg-blue-50 border border-blue-100 shadow-sm transition duration-200 ease-in-out flex items-center'
            : 'block w-[calc(100%-2rem)] mx-auto my-2 rounded-xl px-4 py-3 text-start text-base font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 border border-transparent hover:border-slate-200 transition duration-200 ease-in-out flex items-center';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <span class="mr-2 opacity-70">
        @if($active ?? false)
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
        @else
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
        @endif
    </span>
    {{ $slot }}
</a>
