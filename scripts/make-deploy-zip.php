<?php

$root = realpath(dirname(__DIR__));
$zipPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'a2-full-deploy.zip';

if (is_file($zipPath)) {
    unlink($zipPath);
}

$skipNames = [
    '.git' => true,
    'node_modules' => true,
    '.env' => true,
    'a2consulting_deploy.zip' => true,
    'hostinger-install.php' => true,
    'scripts' => true,
    'a2-full-deploy.zip' => true,
    'storage' => true,
];

$zip = new ZipArchive();
if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    fwrite(STDERR, "Impossible de créer l'archive.\n");
    exit(1);
}

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($iterator as $file) {
    $path = $file->getPathname();
    $relative = substr($path, strlen($root) + 1);
    $relative = str_replace('\\', '/', $relative);
    $parts = explode('/', $relative);

    if (isset($skipNames[$parts[0]])) {
        continue;
    }
    if ($relative === '.env' || str_ends_with($relative, '/.env')) {
        continue;
    }
    if (str_starts_with($relative, 'storage/logs/') && !str_ends_with($relative, '.gitignore')) {
        continue;
    }

    if ($file->isDir()) {
        $zip->addEmptyDir($relative);
    } else {
        $zip->addFile($path, $relative);
    }
}

$zip->close();
echo $zipPath . PHP_EOL;
echo filesize($zipPath) . PHP_EOL;
