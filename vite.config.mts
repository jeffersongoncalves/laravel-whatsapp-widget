import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import { compression } from 'vite-plugin-compression2';

export default defineConfig({
    plugins: [
        laravel({
            buildDirectory: '../resources/dist',
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/wa-redirect.css',
                'resources/js/wa-redirect.js',
                'resources/images/whatsapp-icon-a.svg',
                'resources/images/whatsapp-icon-logo.svg',
                'resources/images/whatsapp-icon-redirect.png',
                'resources/images/whatsapp.svg',
                'resources/midia/alert.mp3',
            ],
            refresh: true,
        }),
        compression(),
        // @ts-ignore
        compression({ algorithm: 'brotliCompress', exclude: [/\.(br)$/, /\.(gz)$/]}),
    ],
});
