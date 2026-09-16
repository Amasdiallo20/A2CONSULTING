import { cpSync, existsSync, mkdirSync } from 'node:fs';
import { resolve } from 'node:path';

const root = process.cwd();
const publicBuild = resolve(root, 'public/build');
const dist = resolve(root, 'dist');

function copyDir(from, to) {
    if (!existsSync(from)) {
        return false;
    }

    mkdirSync(to, { recursive: true });
    cpSync(from, to, { recursive: true });

    return true;
}

if (!existsSync(publicBuild) && existsSync(dist)) {
    copyDir(dist, publicBuild);
}

if (existsSync(publicBuild) && !existsSync(dist)) {
    copyDir(publicBuild, dist);
}

if (!existsSync(publicBuild)) {
    console.error('Vite n’a pas produit public/build. Vérifiez vite.config.js (outDir).');
    process.exit(1);
}

console.log('Sortie Vite prête : public/build');
