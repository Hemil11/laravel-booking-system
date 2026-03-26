/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    50: '#f3f4ff',
                    100: '#e9eaff',
                    200: '#d6d8ff',
                    300: '#b6b9ff',
                    400: '#8f95ff',
                    500: '#6c72ff',
                    600: '#554dff',
                    700: '#4a3ee6',
                    800: '#3d35ba',
                    900: '#352f92',
                },
                accent: {
                    50: '#ecfeff',
                    100: '#cffafe',
                    200: '#a5f3fc',
                    300: '#67e8f9',
                    400: '#22d3ee',
                    500: '#06b6d4',
                    600: '#0891b2',
                    700: '#0e7490',
                    800: '#155e75',
                    900: '#164e63',
                },
                background: {
                    DEFAULT: '#f8fafc',
                    elevated: '#ffffff',
                    muted: '#f1f5f9',
                },
                text: {
                    DEFAULT: '#0f172a',
                    muted: '#475569',
                    subtle: '#64748b',
                    inverse: '#ffffff',
                },
                border: {
                    DEFAULT: '#e2e8f0',
                    strong: '#cbd5e1',
                },
                success: '#16a34a',
                warning: '#d97706',
                danger: '#dc2626',
            },
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
            fontSize: {
                'display-lg': ['3rem', { lineHeight: '1.1', fontWeight: '700' }],
                'display-md': ['2.25rem', { lineHeight: '1.15', fontWeight: '700' }],
                h1: ['2rem', { lineHeight: '1.2', fontWeight: '700' }],
                h2: ['1.5rem', { lineHeight: '1.25', fontWeight: '700' }],
                h3: ['1.25rem', { lineHeight: '1.3', fontWeight: '600' }],
                body: ['1rem', { lineHeight: '1.6', fontWeight: '400' }],
                small: ['0.875rem', { lineHeight: '1.5', fontWeight: '400' }],
            },
            spacing: {
                18: '4.5rem',
                22: '5.5rem',
                26: '6.5rem',
            },
            borderRadius: {
                xl: '0.875rem',
                '2xl': '1rem',
                '3xl': '1.5rem',
            },
            boxShadow: {
                soft: '0 8px 24px rgba(15, 23, 42, 0.08)',
                card: '0 2px 10px rgba(15, 23, 42, 0.06)',
            },
        },
    },
};
