import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/dashboard/charts/bar_users.js',
                'resources/js/dashboard/charts/bar_clients.js',
                'resources/js/dashboard/charts/donut_projects.js',
                'resources/js/dashboard/charts/donut_tasks.js'
            ],
            refresh: true,
        }),
    ],
});
