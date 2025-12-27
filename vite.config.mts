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
            ],
            refresh: true,
        }),
        compression(),
        // @ts-ignore
        compression({ algorithm: 'brotliCompress', exclude: [/\.(br)$/, /\.(gz)$/]}),
    ],
});
