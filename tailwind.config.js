import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            opacity: {
                '94' : '0.94',
            },
            backgroundImage: {
                'homepage-bg': "url('/images/bg-img.jpg')",
            },

            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                satoshi: ['Satoshi', 'sans-serif'],
                poppins: ['Poppins', 'sans-serif'],
            },
            colors: {
                'softwhite' : '#f8f9fa',
                'custom-gray': 'rgb(222, 228, 238)',
                'custombg-gray' : '#1C2434',
                'sidebar-menu' : '#8A99AF',
                'button-bg' : '#3E4DB5',
                'azure-color':'#1C87C8',
                'bg-violet': '#020F1F',
            },
            fontSize:{
                '1.2rem': "1.2rem",
            },
            fontWeight:{
                '400': '400',
            },
        
            width: {
                'custom-sidebar-width' : '290px',
                '1366px': '1170px',
            },
            
        },
    },

    plugins: [forms],
};
