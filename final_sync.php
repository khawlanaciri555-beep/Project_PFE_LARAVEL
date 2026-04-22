<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Synchronizing with EXACT paths from screenshot...\n";

// 1. Hero Slideshow (Jardin Majorelle ID 3)
$gallery = [
    'jrdan majolin/1.png',
    'jrdan majolin/2.png',
    'jrdan majolin/3.png',
    'jrdan majolin/4.png'
];
DB::table('places')->where('id', 3)->update([
    'image' => 'jrdan majolin/1.png',
    'gallery' => json_encode($gallery)
]);

// 2. Hotels (Mapping EXACTLY from screenshot)
$hotelMapping = [
    '2Ciels Boutique Hôtel' => 'jardan majoyin/heberjomon/hotel/2Ciels Boutique Hôtel.png',
    'Blue Sea Le Printemps' => 'jardan majoyin/heberjomon/hotel/Blue Sea Le Printemps.png',
    'Hotel Majorelle' => 'jardan majoyin/heberjomon/hotel/Hotel Majorelle.png',
    'Hotel Toulousain' => 'jardan majoyin/heberjomon/hotel/Hotel Toulousain.png'
];

foreach ($hotelMapping as $title => $path) {
    // Update hotels table
    DB::table('hotels')
        ->where('description', 'LIKE', '%' . $title . '%')
        ->orWhere('email', 'LIKE', '%' . str_replace(' ', '', strtolower($title)) . '%')
        ->update(['image' => $path]);
        
    // Update services table
    DB::table('services')
        ->where('title', 'LIKE', '%' . $title . '%')
        ->update(['image' => $path]);
        
    echo "Updated path for $title to $path\n";
}

echo "Final synchronization complete.\n";
