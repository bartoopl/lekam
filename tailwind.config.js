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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#f0f0ff',
                    100: '#e1e1ff',
                    200: '#c3c3ff',
                    300: '#a5a5ff',
                    400: '#8787ff',
                    500: '#21235F',
                    600: '#1a1a4d',
                    700: '#151540',
                    800: '#0f0f33',
                    900: '#0a0a26',
                },
                lekam: {
                    primary: '#21235F',
                    secondary: '#1a1a4d',
                    accent: '#3B82F6',
                    success: '#10B981',
                    danger: '#EF4444',
                    warning: '#F59E0B',
                    info: '#06B6D4',
                }
            },
            borderRadius: {
                'xl': '16px',
                '2xl': '20px',
            },
        },
    },

    plugins: [forms],
};
