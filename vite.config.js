import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/dist', // Specify the output directory here
        manifest: true,
        base: '/',
        root: './src',
        assetsDir: 'public/dist', // This can be adjusted based on your project structure
    },
});