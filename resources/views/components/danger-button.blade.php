<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-red-600 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-wider hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-[#0C0C0C] transition ease-in-out duration-200']) }}>
    {{ $slot }}
</button>
