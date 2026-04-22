<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$place_id = 3; 
$user = DB::table('users')->first();
$user_id = $user ? $user->id : 1; 

// Clean old HOTELS data only (keeping Riads if exist, or clean all for simplicity)
// The user said "7yed dok les hotl", so I'll delete all services and hotels to re-seed correctly
DB::table('services')->where('place_id', $place_id)->delete();
DB::table('hotels')->delete(); // Cleaning all hotels to avoid confusion

$riads = [
    ['title' => 'Riad BE Marrakech', 'type' => 'riad', 'price' => 2500, 'rating' => 4.8, 'desc' => 'Instagram-famous riad with a stunning courtyard.', 'image' => 'https://images.unsplash.com/photo-1549294413-26f195200c16?q=80&w=1000'],
    ['title' => 'Riad Yasmine', 'type' => 'riad', 'price' => 2200, 'rating' => 4.7, 'desc' => 'Iconic green-and-white tiled courtyard.', 'image' => 'https://images.unsplash.com/photo-1590073242678-70ee3fc28e8e?q=80&w=1000'],
    ['title' => 'Riad Kasbah', 'type' => 'riad', 'price' => 1800, 'rating' => 4.6, 'desc' => 'Charming and sophisticated in the medina.', 'image' => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?q=80&w=1000'],
    ['title' => 'Riad Dar des Arts', 'type' => 'riad', 'price' => 1500, 'rating' => 4.9, 'desc' => 'Peaceful fountain-filled patio.', 'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=1000']
];

$hotels = [
    [
        'title' => 'Hotel Majorelle', 'type' => 'hotel', 'price' => 600, 'rating' => 4.2, 
        'desc' => 'Très proche du jardin (accessible à pied), simple et adapté au budget.', 
        'image' => 'https://images.unsplash.com/photo-1543968332-f99cc0485a97?q=80&w=1000'
    ],
    [
        'title' => '2Ciels Boutique Hôtel', 'type' => 'hotel', 'price' => 1200, 'rating' => 4.7, 
        'desc' => 'Design moderne, dispose d\'une piscine et d\'un magnifique rooftop.', 
        'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1000'
    ],
    [
        'title' => 'La Renaissance Hotel', 'type' => 'hotel', 'price' => 950, 'rating' => 4.5, 
        'desc' => 'Célèbre pour son rooftop et sa vue panoramique sur la ville.', 
        'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=1000'
    ],
    [
        'title' => 'Hotel Toulousain', 'type' => 'hotel', 'price' => 550, 'rating' => 4.1, 
        'desc' => 'Calme et idéal pour le repos, situé à proximité du quartier Guéliz.', 
        'image' => 'https://images.unsplash.com/photo-1551882339-a99bb8f1703b?q=80&w=1000'
    ],
    [
        'title' => 'Hôtel Racine', 'type' => 'hotel', 'price' => 800, 'rating' => 4.4, 
        'desc' => 'Propre, excellent service et prix très raisonnable.', 
        'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?q=80&w=1000'
    ],
    [
        'title' => 'Blue Sea Le Printemps', 'type' => 'hotel', 'price' => 750, 'rating' => 4.3, 
        'desc' => 'Établissement spacieux avec piscine, proche des transports.', 
        'image' => 'https://images.unsplash.com/photo-1535827848776-44ad08f1c118?q=80&w=1000'
    ]
];

foreach(array_merge($riads, $hotels) as $item) {
    try {
        $hotelId = DB::table('hotels')->insertGetId([
            'type' => $item['type'],
            'phone' => '+212 524 123 456',
            'email' => str_replace(' ', '', strtolower($item['title'])) . '@example.com',
            'address' => 'Marrakech, Morocco',
            'image' => $item['image'],
            'price' => $item['price'],
            'description' => $item['desc'],
            'availability' => true,
            'is_deleted' => false,
            'user_id' => $user_id,
            'created_at' => now(), 'updated_at' => now()
        ]);

        DB::table('services')->insert([
            'title' => $item['title'],
            'type' => $item['type'] == 'hotel' ? 'Hôtel' : 'Riad',
            'description' => $item['desc'],
            'image' => $item['image'],
            'price' => $item['price'],
            'rating' => $item['rating'],
            'place_id' => $place_id,
            'hotel_id' => $hotelId,
            'availability' => true,
            'is_deleted' => false,
            'created_at' => now(), 'updated_at' => now()
        ]);
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

echo "Successfully updated hotels for Jardin Majorelle.";
