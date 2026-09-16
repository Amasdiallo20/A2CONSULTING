import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

const rootDir = dirname(fileURLToPath(import.meta.url));

export default defineConfig({
    plugins: [
        laravel({
            publicDirectory: 'public',
            buildDirectory: 'build',
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        outDir: resolve(rootDir, 'public/build'),
        emptyOutDir: true,
        manifest: true,
    },
});
