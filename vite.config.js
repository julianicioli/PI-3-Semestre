import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";

// https://vitejs.dev/config/
export default defineConfig({
  base: "/Testando-React-Vite/", // necessário para GitHub Pages
  plugins: [react()],
  server: {
    proxy: {
      // todas as requisições para /api serão redirecionadas para OpenWeatherMap
      "/api": {
        target: "https://api.openweathermap.org",
        changeOrigin: true,
        rewrite: (path) => path.replace(/^\/api/, ""),
      },
    },
  },
});
