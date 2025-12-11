import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',

                // ⬇️ tambahin file theme Filament kamu di sini
                'resources/css/filament/gft-noa-theme.css',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
