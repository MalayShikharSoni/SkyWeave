import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                // Deep navy/charcoal aviation palette
                sky: {
                    950: '#0a0e1a',
                    900: '#0f1629',
                    850: '#131b33',
                    800: '#182240',
                    700: '#1e2d52',
                    600: '#2a3f6e',
                    500: '#3a5591',
                    400: '#5a7ab5',
                    300: '#8aa4d0',
                    200: '#b5c7e3',
                    100: '#dce5f2',
                    50:  '#f0f4fa',
                },
                // Accent — aviation cyan/teal
                accent: {
                    DEFAULT: '#38bdf8',
                    50:  '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                },
                // Warm amber for warnings and route highlights
                route: {
                    DEFAULT: '#f59e0b',
                    light: '#fbbf24',
                    dark: '#d97706',
                },
                // Status greens
                nav: {
                    vor: '#10b981',
                    dme: '#6366f1',
                    ndb: '#f97316',
                    tacan: '#ec4899',
                    fix: '#64748b',
                },
            },
            boxShadow: {
                'glow': '0 0 20px rgba(56, 189, 248, 0.15)',
                'glow-lg': '0 0 40px rgba(56, 189, 248, 0.2)',
                'inner-glow': 'inset 0 1px 0 rgba(255, 255, 255, 0.05)',
            },
            backgroundImage: {
                'grid-pattern': 'linear-gradient(rgba(56, 189, 248, 0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(56, 189, 248, 0.03) 1px, transparent 1px)',
            },
            backgroundSize: {
                'grid': '40px 40px',
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-out',
                'slide-up': 'slideUp 0.5s ease-out',
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { opacity: '0', transform: 'translateY(10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
        },
    },

    plugins: [forms],
};
