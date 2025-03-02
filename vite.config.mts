import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import inject from '@rollup/plugin-inject';
import { compression } from 'vite-plugin-compression2';

export default defineConfig({
    plugins: [
        inject({
            include: '**/*.js',
            exclude: 'node_modules/**',
            $: 'jquery',
            jQuery: 'jquery',
        }),
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
        compression({ algorithm: 'brotliCompress', exclude: [/\.(br)$/, /\.(gz)$/]}),
    ],
});
