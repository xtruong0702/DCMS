<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-[#0D7A68] hover:bg-[#0B6858] active:bg-[#095246] border border-transparent rounded-xl font-bold text-xs text-white shadow-xs focus:outline-none focus:ring-2 focus:ring-[#0D7A68] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
