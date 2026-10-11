<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center rounded-xl bg-emerald-800 px-4 py-2 font-semibold text-sm text-white hover:bg-emerald-900 active:bg-emerald-950 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
