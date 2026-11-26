@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-200 focus:border-[#0D7A68] focus:ring-[#0D7A68] rounded-xl text-xs shadow-xs text-slate-800']) }}>
