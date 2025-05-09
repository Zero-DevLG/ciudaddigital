import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/landing_page.css',
                'resources/css/login.css',
                'resources/css/configuration.css',
                'resources/js/app.js'

            ],
            refresh: true,
        }),
    ],
});
