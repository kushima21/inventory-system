import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: 
            ['resources/css/app.css',
            'resources/css/default.css',
            'resources/css/personnel.css',
            'resources/css/settings.css',
            'resources/css/supplies.css',
            'resources/css/equipment.css',
            'resources/css/gym.css',
            'resources/css/faculty.css',
            'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
