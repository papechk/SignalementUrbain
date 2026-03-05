@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-xl border border-gray-300 dark:border-white/[0.12] bg-white dark:bg-[#0C0C0C] text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:border-[#BEFF00] dark:focus:border-[#BEFF00] focus:ring-[#BEFF00] dark:focus:ring-[#BEFF00] focus:ring-1 shadow-none transition placeholder:text-gray-400 dark:placeholder:text-gray-600']) }}>
