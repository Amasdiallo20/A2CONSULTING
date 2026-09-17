<?php

$root = realpath(__DIR__ . '/..');
$zipPath = $root . '/storage/app/laravel-code.zip';

if (is_file($zipPath)) {
    unlink($zipPath);
}

$zip = new ZipArchive();
if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    fwrite(STDERR, "Impossible de creer l'archive.\n");
    exit(1);
}

$dirs = ['app', 'bootstrap', 'config', 'database', 'resources/views', 'routes', 'css', 'js', 'public/css', 'public/js'];
foreach ($dirs as $dir) {
    $fullDir = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $dir);
    if (! is_dir($fullDir)) {
        fwrite(STDERR, "Dossier manquant: {$dir}\n");
        exit(1);
    }
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($fullDir, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($iterator as $file) {
        if (! $file->isFile()) {
            continue;
        }
        $local = substr($file->getPathname(), strlen($root) + 1);
        $local = str_replace('\\', '/', $local);
        if (str_contains($local, '/cache/') && str_ends_with($local, '.php') && ! str_ends_with($local, 'packages.php') && ! str_ends_with($local, 'services.php')) {
            continue;
        }
        $zip->addFile($file->getPathname(), $local);
    }
}

foreach (['artisan', 'composer.json', 'composer.lock', '.htaccess', 'public/.htaccess'] as $file) {
    $zip->addFile($root . DIRECTORY_SEPARATOR . $file, $file);
}

$zip->close();
echo $zipPath . PHP_EOL;
echo filesize($zipPath) . PHP_EOL;
