<?php

$zipPath = __DIR__.'/../storage/app/laravel-code.zip';
$zip = new ZipArchive();
if ($zip->open($zipPath) !== true) {
    fwrite(STDERR, "open fail\n");
    exit(1);
}
$zip->addFile(__DIR__.'/../storage/app/_runmigrate.php', 'public/_runmigrate.php');
$zip->addFile(__DIR__.'/../storage/app/_clearviews.php', 'public/_clearviews.php');
$zip->close();
echo filesize($zipPath).PHP_EOL;
