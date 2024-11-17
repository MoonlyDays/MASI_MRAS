import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { glob, globSync } from "glob";

const input = [
    "resources/js/app.ts",
    "resources/js/main.js",
    ...Object.values(glob.sync("resources/img/**/*")),
];

export default defineConfig({
    plugins: [
        laravel({
            input: input,
            refresh: true,
        }),
    ],
});
