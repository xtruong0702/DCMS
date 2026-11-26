@props(['align' => 'right', 'width' => '56', 'contentClasses' => 'py-2 bg-white/95 backdrop-blur-xl'])

@php
$alignmentClasses = match ($align) {
    'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
    'top' => 'origin-top',
    default => 'ltr:origin-top-right rtl:origin-top-left end-0',
};

$width = match ($width) {
    '48' => 'w-56',
    '56' => 'w-60',
    '64' => 'w-64',
    '80' => 'w-80',
    '96' => 'w-96',
    default => (str_starts_with($width, 'w-') || str_starts_with($width, 'max-w-') ? $width : (is_numeric($width) ? 'w-' . $width : $width)),
};
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-1 scale-95"
            class="absolute z-50 mt-2.5 {{ $width }} rounded-2xl shadow-xl shadow-slate-900/10 border border-slate-200/80 {{ $alignmentClasses }}"
            style="display: none;"
            @click="open = false">
        <div class="rounded-2xl overflow-hidden {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
