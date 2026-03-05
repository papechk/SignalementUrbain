<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-5 py-2.5 bg-white dark:bg-[#161616] border border-gray-300 dark:border-white/[0.12] rounded-xl font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-wider shadow-none hover:bg-gray-50 dark:hover:bg-white/[0.04] focus:outline-none focus:ring-2 focus:ring-[#BEFF00] focus:ring-offset-2 dark:focus:ring-offset-[#0C0C0C] disabled:opacity-25 transition ease-in-out duration-200']) }}>
    {{ $slot }}
</button>
