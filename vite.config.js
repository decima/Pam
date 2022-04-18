import {defineConfig} from "vite";
import symfonyPlugin from "vite-plugin-symfony";
import {svelte} from "@sveltejs/vite-plugin-svelte";

/* if you're using React */
// import react from '@vitejs/plugin-react';

export default defineConfig({
    server: {
        watch: {
            ignored: ['**/var','**/vendor',"**/media"]
        }
    },
    plugins: [
        /* react(), // if you're using React */
        symfonyPlugin(),
        svelte(),
    ],
    root: ".",
    base: "/build/",
    build: {
        manifest: true,
        emptyOutDir: true,
        assetsDir: "",
        outDir: "./public/build",
        rollupOptions: {
            input: {
                app: "./assets/app.js"
            },
        },
    },
});
