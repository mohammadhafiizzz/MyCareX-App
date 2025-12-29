import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import glob from 'fast-glob'; // Import the library

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                // Use glob.sync to find all files and expand them into the array
                ...glob.sync('resources/js/main/**/*.js'),
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
