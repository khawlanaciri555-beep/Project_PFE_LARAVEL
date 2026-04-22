<?php

use Illuminate\Support\Facades\DB;

$hotelMapping = [
    '2Ciels Boutique Hôtel' => 'places/Jardin Majorelle/hebrjomon/hotel/2Ciels Boutique Hôtel.png',
    'Blue Sea Le Printemps' => 'places/Jardin Majorelle/hebrjomon/hotel/Blue Sea Le Printemps.png',
    'Hotel Majorelle' => 'places/Jardin Majorelle/hebrjomon/hotel/Hotel Majorelle.png',
    'Hotel Toulousain' => 'places/Jardin Majorelle/hebrjomon/hotel/Hotel Toulousain.png'
];

foreach ($hotelMapping as $title => $path) {
    // Update hotels table
    $affectedHotels = DB::table('hotels')
        ->where('description', 'ILIKE', '%' . $title . '%')
        ->orWhere('email', 'ILIKE', '%' . str_replace(' ', '', strtolower($title)) . '%')
        ->update(['image' => $path]);
        
    // Update services table
    $affectedServices = DB::table('services')
        ->where('title', 'ILIKE', '%' . $title . '%')
        ->update(['image' => $path]);
        
    echo "Updated path for $title to $path (Hotels: $affectedHotels, Services: $affectedServices)\n";
}

echo "Done mapping hotels.\n";
