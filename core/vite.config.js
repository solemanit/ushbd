import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";
import { viteStaticCopy } from "vite-plugin-static-copy";

// Environment detection
const isDev = process.env.NODE_ENV === "development";
const isProd = !isDev;

// Common path configurations
const RESOURCES_PATH = path.resolve(__dirname, "resources");
const ASSETS_PATH = path.resolve(RESOURCES_PATH, "assets");
const FRONTEND_PATH = path.resolve(ASSETS_PATH, "frontend");
const BACKEND_PATH = path.resolve(ASSETS_PATH, "backend");
const PUBLIC_PATH = path.resolve(__dirname, "../public");

// File copy configurations - only third-party/vendor files that shouldn't be processed
const staticFiles = {
    frontend: [
        { src: "css/bootstrap.min.css", dest: "frontend/css" },
        { src: "js/bootstrap.bundle.min.js", dest: "frontend/js" },
        { src: "js/jquery.min.js", dest: "frontend/js" },
        { src: "plugins/slick/slick.min.js", dest: "frontend/plugins/slick" },
    ],
    backend: [
        { src: "css/tom-select.bootstrap5.min.css", dest: "backend/css" },
        { src: "js/jquery-min.js", dest: "backend/js" },
        { src: "js/jquery-ui.min.js", dest: "backend/js" },
        { src: "js/tom-select.complete.min.js", dest: "backend/js" },
        { src: "js/resumable.min.js", dest: "backend/js" },
        { src: "js/list.min.js", dest: "backend/js" },
    ],
};

// Build input configurations - organized by section
const buildInputs = {
    // Core
    "default/app": path.resolve(RESOURCES_PATH, "js/app.js"),
    "default/style": path.resolve(RESOURCES_PATH, "css/app.css"),

    // Backend
    "backend/theme": path.resolve(BACKEND_PATH, "css/theme.css"),
    "backend/jquery-ui": path.resolve(BACKEND_PATH, "css/jquery-ui.css"),
    "backend/back-style": path.resolve(BACKEND_PATH, "css/back-style.css"),
    "backend/back-vendors": path.resolve(BACKEND_PATH, "css/back-vendors.css"),
    "backend/main": path.resolve(BACKEND_PATH, "js/main.js"),
    "backend/dashboard": path.resolve(BACKEND_PATH, "js/dashboard.js"),

    // Frontend
    "frontend/style": path.resolve(FRONTEND_PATH, "css/style.css"),
    "frontend/dark-theme": path.resolve(FRONTEND_PATH, "css/dark-theme.css"),
    "frontend/icons": path.resolve(FRONTEND_PATH, "css/icons.css"),
    "frontend/slick": path.resolve(FRONTEND_PATH, "plugins/slick/slick.css"),
    "frontend/slick-theme": path.resolve(FRONTEND_PATH, "plugins/slick/slick-theme.css"),
    "frontend/main": path.resolve(FRONTEND_PATH, "js/main.js"),
    "frontend/index": path.resolve(FRONTEND_PATH, "js/index.js"),
    "frontend/loader": path.resolve(FRONTEND_PATH, "js/loader.js"),
};

export default defineConfig({
    plugins: [
        laravel({
            input: Object.values(buildInputs),
            publicDirectory: "../public",
            buildDirectory: "assets",
            refresh: [
                "resources/views/**",
                "routes/**",
                "app/Http/Controllers/**",
            ],
        }),

        viteStaticCopy({
            targets: [
                // Backend files
                ...staticFiles.backend.map(({ src, dest }) => ({
                    src: `resources/assets/backend/${src}`,
                    dest: dest, // <- just use dest, don't prepend "assets/"
                })),
                // Frontend files
                ...staticFiles.frontend.map(({ src, dest }) => ({
                    src: `resources/assets/frontend/${src}`,
                    dest: dest, // <- same here
                })),
            ],
        }),
    ],

    build: {
        outDir: path.resolve(PUBLIC_PATH, "assets"),
        emptyOutDir: true,
        manifest: true,
        manifestFileName: "manifest.json",

        minify: "esbuild",
        target: "es2020",
        cssCodeSplit: true,
        sourcemap: isDev ? "inline" : false,
        chunkSizeWarningLimit: 1000,

        rollupOptions: {
            input: buildInputs,
            output: {
                entryFileNames: isProd ? "[name]-[hash].js" : "[name].js",
                chunkFileNames: isProd
                    ? "chunks/[name]-[hash].js"
                    : "chunks/[name].js",
                assetFileNames: (assetInfo) => {
                    const ext = path.extname(assetInfo.name);
                    if (/\.(css)$/.test(assetInfo.name))
                        return isProd
                            ? "[name]-[hash][extname]"
                            : "[name][extname]";
                    if (/\.(png|jpe?g|svg|gif|webp|avif)$/.test(assetInfo.name))
                        return "images/[name]-[hash][extname]";
                    if (/\.(woff2?|eot|ttf|otf)$/.test(assetInfo.name))
                        return "fonts/[name]-[hash][extname]";
                    return isProd
                        ? "[name]-[hash][extname]"
                        : "[name][extname]";
                },

                manualChunks: (id) => {
                    if (id.includes("node_modules")) {
                        if (id.includes("jquery")) return "vendor-jquery";
                        if (id.includes("bootstrap")) return "vendor-bootstrap";
                        if (id.includes("slick")) return "vendor-slick";
                        return "vendor";
                    }
                    if (id.includes("assets/backend"))
                        return id.includes("/js/") ? "backend-js" : "backend";
                    if (id.includes("assets/frontend"))
                        return id.includes("/js/") ? "frontend-js" : "frontend";
                },
            },
            treeshake: {
                moduleSideEffects: "no-external",
                propertyReadSideEffects: false,
                tryCatchDeoptimization: false,
            },
        },

        reportCompressedSize: isProd,
        assetsInlineLimit: 4096,
    },

    resolve: {
        alias: {
            "@": RESOURCES_PATH,
            "@backend": path.resolve(BACKEND_PATH, "js"),
            "@backend-css": path.resolve(BACKEND_PATH, "css"),
            "@frontend": path.resolve(FRONTEND_PATH, "js"),
            "@frontend-css": path.resolve(FRONTEND_PATH, "css"),
            "@assets": ASSETS_PATH,
        },
    },

    server: {
        hmr: { host: "localhost" },
        watch: {
            usePolling: false,
            ignored: ["**/vendor/**", "**/node_modules/**", "**/storage/**"],
        },
    },

    optimizeDeps: {
        include: ["jquery"],
        exclude: ["laravel-vite-plugin"],
        esbuildOptions: { target: "es2020" },
    },

    css: {
        devSourcemap: isDev,
        preprocessorOptions: {
            scss: {
                additionalData: `$env: ${
                    isDev ? "development" : "production"
                };`,
            },
        },
    },

    esbuild: {
        drop: isProd ? ["console", "debugger"] : [],
        legalComments: "none",
    },
});
