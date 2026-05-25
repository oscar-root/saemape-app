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
            colors: {
                'saemape-blue': '#0054A5',
                'saemape-gold': '#FFD700',
                'saemape-red': '#ED1C24',
                'saemape-dark': '#05070A',
            },
            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                'float': 'float 6s ease-in-out infinite',
                'shine': 'shine 5s linear infinite',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-20px)' },
                },
                shine: {
                    '0%': { 'background-position': '200% center' },
                    '100%': { 'background-position': '-200% center' },
                }
            }
        },
    },
    plugins: [forms],
};