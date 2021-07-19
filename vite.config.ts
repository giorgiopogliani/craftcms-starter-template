import { defineConfig } from "vite";

export default defineConfig(({ command }) => ({
  base: command === "serve" ? "" : "/dist/",
  build: {
    manifest: true,
    outDir: "web/dist/",
    rollupOptions: {
      input: {
        app: "assets/app.js",
      },
    },
  },
}));
