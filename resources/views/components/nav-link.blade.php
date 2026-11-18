@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl text-xs font-bold leading-5 text-indigo-700 bg-indigo-50 border border-indigo-200 shadow-xs focus:outline-none transition duration-150 ease-in-out whitespace-nowrap shrink-0'
            : 'inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl text-xs font-bold leading-5 text-slate-600 hover:text-slate-900 hover:bg-slate-100 border border-transparent focus:outline-none transition duration-150 ease-in-out whitespace-nowrap shrink-0';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
