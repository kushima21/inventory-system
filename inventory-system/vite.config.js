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
            'resources/css/request.css',
            'resources/css/login.css',
            'resources/css/signup.css',
            'resources/css/index.css',
            'resources/css/about.css',
            'resources/css/book.css',
            'resources/css/contact.css',
            'resources/css/services.css',
            'resources/css/responsived.css',
            'resources/css/home.css',
            'resources/css/navbar.css',
            'resources/css/sideBar.css',
            'resources/css/profile.css',
            'resources/css/bookRequest.css',
            'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
