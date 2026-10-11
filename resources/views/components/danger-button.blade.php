<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-xl border border-transparent bg-red-700 px-4 py-2 font-semibold text-sm text-white hover:bg-red-800 active:bg-red-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-700 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
