@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold leading-5 text-slate-900 bg-slate-100 border border-slate-200/80 shadow-xs focus:outline-none transition duration-150 ease-in-out whitespace-nowrap shrink-0'
            : 'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold leading-5 text-slate-600 hover:text-slate-900 hover:bg-slate-100 border border-transparent focus:outline-none transition duration-150 ease-in-out whitespace-nowrap shrink-0';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
