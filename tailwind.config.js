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
                // Primary alias = indigo (use indigo-* or brand-* in markup; both match #4f46e5 at 600)
                brand: {
                    50: '#eef2ff',
                    100: '#e0e7ff',
                    200: '#c7d2fe',
                    300: '#a5b4fc',
                    400: '#818cf8',
                    500: '#6366f1',
                    600: '#4f46e5',
                    700: '#4338ca',
                    800: '#3730a3',
                    900: '#312e81',
                },
                // Secondary neutrals (gray scale; pairs with Tailwind gray-* utilities)
                accent: {
                    50: '#f9fafb',
                    100: '#f3f4f6',
                    200: '#e5e7eb',
                    300: '#d1d5db',
                    400: '#9ca3af',
                    500: '#6b7280',
                    600: '#4b5563',
                    700: '#374151',
                    800: '#1f2937',
                    900: '#111827',
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
