import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                display: ['Syne', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#BEFF00',
                accent: '#FFD600',
                dark: '#0C0C0C',
                surface: '#F5F5F0',
            },
        },
    },

    plugins: [forms],
};
