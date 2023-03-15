import { defineConfig } from 'vite'
import { resolve } from 'path'

export default defineConfig({
  build: {
    outDir: '../dist',
    emptyOutDir: true,
    manifest: true,
    minify: true,
    write: true,
    rollupOptions: {
      input: {
        main: resolve( __dirname + '/main.js')
      },
    }
  }
})