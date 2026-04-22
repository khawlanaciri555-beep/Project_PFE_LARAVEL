<?php

use Illuminate\Support\Facades\DB;

$riads = [
    [
        'image' => "places/Jardin Majorelle/hebrjomon/riad/Riad Jnane d'Ô.png", 
        'desc' => "A peaceful oasis offering a stunning garden and terrace, located just 1.3km from the city center."
    ],
    [
        'image' => 'places/Jardin Majorelle/hebrjomon/riad/Riad Matham.png', 
        'desc' => "Traditional Moroccan charm with an affordable price and a beautiful rooftop view of the Medina."
    ],
    [
        'image' => 'places/Jardin Majorelle/hebrjomon/riad/Riad Dar Anika.png', 
        'desc' => "Luxurious stay with premium service and an exquisite traditional courtyard."
    ],
    [
        'image' => 'places/Jardin Majorelle/hebrjomon/riad/Riad Yasmine.png', 
        'desc' => "The most Instagram-famed riad in Marrakech, featuring the iconic central pool and lush garden."
    ]
];

foreach ($riads as $item) {
    // Update hotels table
    DB::table('hotels')
        ->where('image', $item['image'])
        ->update(['description' => $item['desc']]);
        
    // Update services table
    DB::table('services')
        ->where('image', $item['image'])
        ->update(['description' => $item['desc']]);
        
    echo "Updated description for " . $item['image'] . "\n";
}

echo "Done updating riad descriptions.\n";
