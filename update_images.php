<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$basePath = 'jardan majoyin/heberjemon/hotel/';

$updates = [
    '2Ciels Boutique Hôtel' => '2Ciels Boutique Hôtel.png',
    'Blue Sea Le Printemps' => 'Blue Sea Le Printemps.png',
    'Hotel Majorelle' => 'hotel majolin.png',
    'Hotel Toulousain' => 'Toulousain.png'
];

foreach ($updates as $title => $filename) {
    $path = $basePath . $filename;
    // We update using title match
    DB::table('hotels')
        ->where('email', 'LIKE', '%' . str_replace(' ', '', strtolower($title)) . '%')
        ->update(['image' => $path]);
        
    DB::table('services')
        ->where('title', 'LIKE', '%' . $title . '%')
        ->update(['image' => $path]);
}

echo "Successfully updated images for matched hotels.";
