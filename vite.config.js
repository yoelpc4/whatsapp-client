import fs from 'fs'
import {homedir} from 'os'
import {resolve} from 'path'
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: detectServerConfig()
});

function detectServerConfig() {
    const host = 'whatsapp-client.test'

    const homePath = homedir()

    const keyPath = resolve(homePath, `.config/valet/certificates/${host}.key`)

    const certificatePath = resolve(homePath, `.config/valet/certificates/${host}.crt`)

    if (!fs.existsSync(keyPath) || !fs.existsSync(certificatePath)) {
        return {}
    }

    return {
        hmr: {
            host
        },
        host,
        https: {
            key: fs.readFileSync(keyPath),
            cert: fs.readFileSync(certificatePath),
        }
    }
}
