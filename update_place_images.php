<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$placeId = 3;
$gallery = [
    'jrdan majolin/1.png',
    'jrdan majolin/2.png',
    'jrdan majolin/3.png',
    'jrdan majolin/4.png'
];

DB::table('places')->where('id', $placeId)->update([
    'image' => 'jrdan majolin/1.png',
    'gallery' => json_encode($gallery)
]);

echo "Gallery and main image updated for Jardin Majorelle (ID 3).\n";

// Move files to storage if they are in public
$sourceDir = public_path('jrdan majolin');
$destDir = storage_path('app/public/jrdan majolin');

if (!file_exists($destDir)) {
    mkdir($destDir, 0777, true);
}

foreach ($gallery as $file) {
    $src = public_path($file);
    $dst = storage_path('app/public/' . $file);
    if (file_exists($src)) {
        copy($src, $dst);
        echo "Copied $src to $dst\n";
    }
}
