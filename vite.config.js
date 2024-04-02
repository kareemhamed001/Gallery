import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'public/assets/js/app.js',
                'public/assets/js/Album/main.js',
                'public/assets/js/Album/show.js',
            ],
            refresh: true,
        }),
    ],
});
