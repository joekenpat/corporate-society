<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 btn-success border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
