import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                // 'serif' คือชื่อเล่นสำหรับฟอนต์ Crimson Text
                serif: ['"Crimson Text"', ...defaultTheme.fontFamily.serif],
                // 'display' คือชื่อเล่นสำหรับฟอนต์ Mystery Quest
                display: ['"Mystery Quest"', 'cursive'],
            },
        },
    },

    plugins: [forms],
};