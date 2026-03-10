import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        VitePWA({
            registerType: 'autoUpdate',
            devOptions: {
                enabled: true,           // aktifkan PWA di dev mode
                type: 'module',
            },
            includeAssets: ['favicon.ico', 'icons/*.png'],
            manifest: {
                name: 'KedaiApp',
                short_name: 'KedaiApp',
                description: 'Aplikasi Kedai Mobile — Presensi & Kegiatan',
                theme_color: '#2563EB',
                background_color: '#EFF6FF',
                display: 'standalone',
                orientation: 'portrait',
                start_url: '/home',
                scope: '/',
                lang: 'id',
                icons: [
                    {
                        src: '/icons/icon-192.png',
                        sizes: '192x192',
                        type: 'image/png',
                        purpose: 'any',
                    },
                    {
                        src: '/icons/icon-512.png',
                        sizes: '512x512',
                        type: 'image/png',
                        purpose: 'any maskable',
                    },
                ],
            },
            workbox: {
                globPatterns: ['**/*.{js,css,html,ico,png,svg}'],
                navigateFallback: null, // biarkan Laravel handle routing
            },
        }),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
