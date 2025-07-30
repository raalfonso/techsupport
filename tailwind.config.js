import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',  // Enables class-based dark mode
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './node_modules/flowbite/**/*.js'
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#3b82f6',  // Example custom color for primary buttons
                secondary: '#6b7280',  // Secondary color for accents
                dark: {
                    100: '#1f2937',
                    200: '#1c1f24',
                    300: '#111827',  // Custom dark shades for background and text
                }
            }
        },
    },
    plugins: [
    require('flowbite/plugin')
  ],
};
