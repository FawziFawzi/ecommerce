import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import sass from 'sass';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/assets/sass/app.scss', 'resources/assets/js/app.js'],
            refresh: true,
        }),

    ],
});
