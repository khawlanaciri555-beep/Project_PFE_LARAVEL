<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

$placesDir = public_path('storage/places');
$places = DB::table('places')->get();

foreach ($places as $place) {
    if (trim($place->name) == '') continue;

    $placeFolder = $placesDir . DIRECTORY_SEPARATOR . trim($place->name);
    
    if (File::exists($placeFolder) && File::isDirectory($placeFolder)) {
        $files = File::files($placeFolder);
        $images = [];
        foreach ($files as $file) {
            $ext = strtolower($file->getExtension());
            if (in_array($ext, ['jpeg', 'jpg', 'png', 'webp'])) {
                // Return path relative to the disk configured for Laravel (storage/places)
                // e.g. /storage/places/Jardin Majorelle/image.jpeg
                $images[] = '/storage/places/' . trim($place->name) . '/' . $file->getFilename();
            }
        }

        if (count($images) > 0) {
            $mainImage = $images[0];
            $galleryInfo = json_encode($images);
            
            DB::table('places')->where('id', $place->id)->update([
                'image' => $mainImage,
                'gallery' => $galleryInfo
            ]);
            
            echo "Updated {$place->name} with " . count($images) . " images.\n";
        } else {
            echo "No images found for {$place->name}.\n";
        }
    } else {
        echo "Directory not found for {$place->name}: $placeFolder\n";
    }
}
echo "Done synchronizing photos.\n";

