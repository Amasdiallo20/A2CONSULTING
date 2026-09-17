<?php

$root = realpath(__DIR__ . '/..');
$zipPath = $root . '/storage/app/deploy-update.zip';

if (is_file($zipPath)) {
    unlink($zipPath);
}

$files = [
    'app/Models/Event.php',
    'app/Models/Course.php',
    'app/Models/ShopProduct.php',
    'app/Services/Cart.php',
    'app/Http/Controllers/Admin/EventController.php',
    'app/Http/Controllers/Admin/ShopController.php',
    'app/Http/Middleware/PreventHtmlCache.php',
    'app/Http/Middleware/PurgePublicCache.php',
    'bootstrap/app.php',
    'routes/admin.php',
    '.htaccess',
    'public/.htaccess',
    'css/site-mobile.css',
    'public/css/site-mobile.css',
    'resources/views/pages/home.blade.php',
    'resources/views/pages/events.blade.php',
    'resources/views/pages/events-single.blade.php',
    'resources/views/pages/courses-single.blade.php',
    'resources/views/partials/course-card.blade.php',
    'resources/views/partials/product-price.blade.php',
    'resources/views/admin/events/edit.blade.php',
    'resources/views/admin/events/index.blade.php',
    'resources/views/admin/events/show.blade.php',
    'resources/views/admin/shop/edit.blade.php',
    'resources/views/admin/shop/create.blade.php',
    'resources/views/admin/layouts/app.blade.php',
    'resources/views/layouts/app.blade.php',
];

$zip = new ZipArchive();
if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    fwrite(STDERR, "Impossible de créer l'archive.\n");
    exit(1);
}

foreach ($files as $file) {
    $full = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file);
    if (!is_file($full)) {
        fwrite(STDERR, "Fichier manquant: {$file}\n");
        exit(1);
    }
    $zip->addFile($full, $file);
}

$zip->close();
echo $zipPath . PHP_EOL;
echo filesize($zipPath) . PHP_EOL;
