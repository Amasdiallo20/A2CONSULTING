<?php

$root = realpath(__DIR__ . '/..');
$zipPath = $root . '/storage/app/public-assets.zip';

if (is_file($zipPath)) {
    unlink($zipPath);
}

$zip = new ZipArchive();
if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    fwrite(STDERR, "Impossible de creer l'archive.\n");
    exit(1);
}

$dirs = ['public/css', 'public/js', 'public/fonts', 'public/vendor'];
foreach ($dirs as $dir) {
    $fullDir = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $dir);
    if (! is_dir($fullDir)) {
        continue;
    }
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($fullDir, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($iterator as $file) {
        if (! $file->isFile()) {
            continue;
        }
        $local = substr($file->getPathname(), strlen($root) + 1);
        $zip->addFile($file->getPathname(), str_replace('\\', '/', $local));
    }
}

$zip->close();
echo $zipPath . PHP_EOL;
echo filesize($zipPath) . PHP_EOL;
