import {
    defineConfig,
    loadEnv
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";
import fs from 'node:fs';
import os from 'node:os';
import path from 'node:path';

// Serve dev assets over HTTPS when the site itself is served over HTTPS
// (Herd/Valet), otherwise the browser blocks them as mixed content.
// Set VITE_DEV_HOST=pekral.test in .env to enable it; without the variable
// (CI, Docker, plain `npm run dev`) nothing below applies.
const certificateDirectory = path.join(
    os.homedir(),
    'Library/Application Support/Herd/config/valet/Certificates',
);

const readCertificate = (host) => {
    const key = path.join(certificateDirectory, `${host}.key`);
    const cert = path.join(certificateDirectory, `${host}.crt`);

    if (!fs.existsSync(key) || !fs.existsSync(cert)) {
        return undefined;
    }

    return {
        key: fs.readFileSync(key),
        cert: fs.readFileSync(cert),
    };
};

export default defineConfig(({ mode }) => {
    // Vite does not copy .env into process.env, so the host has to be read
    // through loadEnv - reading process.env directly always yields undefined
    // and silently falls back to plain HTTP.
    const devHost = loadEnv(mode, process.cwd(), '').VITE_DEV_HOST;
    const certificate = devHost ? readCertificate(devHost) : undefined;

    return {
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/fe.js', 'resources/css/fe.css'],
                refresh: true,
            }),
            tailwindcss(),
        ],
        server: {
            cors: true,
            ...(certificate ? { host: devHost, https: certificate } : {}),
        },
    };
});
