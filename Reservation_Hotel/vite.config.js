import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'; // ✅ Ajouter
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
     resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler.js', // 🔹 Important
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
