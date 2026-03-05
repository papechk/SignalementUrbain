<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 rounded-xl font-semibold text-sm text-[#0C0C0C] uppercase tracking-wider transition ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-[#0C0C0C]', 'style' => 'background-color: #BEFF00; --tw-ring-color: #BEFF00;']) }}>
    {{ $slot }}
</button>
