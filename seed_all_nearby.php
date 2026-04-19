<?php

use Illuminate\Support\Facades\DB;

$places = DB::table('places')->where('is_deleted', false)->get();
$user = DB::table('users')->first();
$user_id = $user ? $user->id : 1;

$nearbyData = [
    'Place Jemaa el-Fna' => [
        ['title' => 'Riad Monceau', 'type' => 'riad', 'price' => 1800, 'img' => 'https://images.unsplash.com/photo-1549294413-26f195200c16'],
        ['title' => 'Hotel Les Jardins de la Koutoubia', 'type' => 'hotel', 'price' => 3500, 'img' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945']
    ],
    'Palais de la Bahia' => [
        ['title' => 'Riad Bahia', 'type' => 'riad', 'price' => 1200, 'img' => 'https://images.unsplash.com/photo-1590073242678-70ee3fc28e8e'],
        ['title' => 'Riad de la Belle Epoque', 'type' => 'riad', 'price' => 1400, 'img' => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6']
    ],
    'Mosquée Koutoubia' => [
        ['title' => 'La Mamounia', 'type' => 'hotel', 'price' => 8000, 'img' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b'],
        ['title' => 'Hotel Ali', 'type' => 'hotel', 'price' => 400, 'img' => 'https://images.unsplash.com/photo-1551882339-a99bb8f1703b']
    ],
    'Medersa Ben Youssef' => [
        ['title' => 'Riad Star', 'type' => 'riad', 'price' => 1600, 'img' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4'],
        ['title' => 'Riad Ennakhil', 'type' => 'riad', 'price' => 900, 'img' => 'https://images.unsplash.com/photo-1543968332-f99cc0485a97']
    ],
    'Quartier de Guéliz' => [
        ['title' => 'Radisson Blu Hotel', 'type' => 'hotel', 'price' => 2200, 'img' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39'],
        ['title' => 'Hotel Diwane', 'type' => 'hotel', 'price' => 850, 'img' => 'https://images.unsplash.com/photo-1535827848776-44ad08f1c118']
    ],
    'Vallée de l\'Ourika' => [
        ['title' => 'Kasbah Bab Ourika', 'type' => 'hotel', 'price' => 3000, 'img' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d'],
        ['title' => 'Le Jardin de l\'Ourika', 'type' => 'riad', 'price' => 1100, 'img' => 'https://images.unsplash.com/photo-1540541338287-41700207dee6']
    ]
];

foreach ($places as $place) {
    if ($place->name === 'Jardin Majorelle') continue; // Already done

    $data = $nearbyData[$place->name] ?? [
        ['title' => "Riad {$place->name}", 'type' => 'riad', 'price' => 1300, 'img' => 'https://images.unsplash.com/photo-1549294413-26f195200c16'],
        ['title' => "Hotel {$place->name}", 'type' => 'hotel', 'price' => 900, 'img' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945']
    ];

    foreach ($data as $item) {
        try {
            $hotelId = DB::table('hotels')->insertGetId([
                'type' => $item['type'],
                'phone' => '+212 524 111 222',
                'email' => str_replace([' ', '\''], '', strtolower($item['title'])) . '@example.com',
                'address' => "Near {$place->name}, Marrakech",
                'image' => $item['img'],
                'price' => $item['price'],
                'description' => "A beautiful " . ($item['type'] == 'riad' ? "traditional" : "modern") . " stay located right next to {$place->name}.",
                'availability' => true,
                'is_deleted' => false,
                'user_id' => $user_id,
                'created_at' => now(), 'updated_at' => now()
            ]);

            DB::table('services')->insert([
                'title' => $item['title'],
                'type' => ($item['type'] == 'hotel' ? 'Hôtel' : 'Riad'),
                'description' => "Stay close to the heart of Marrakech's culture. Excellent service and authentic atmosphere.",
                'image' => $item['img'],
                'price' => $item['price'],
                'rating' => 4.5,
                'place_id' => $place->id,
                'hotel_id' => $hotelId,
                'availability' => true,
                'is_deleted' => false,
                'created_at' => now(), 'updated_at' => now()
            ]);
            echo "Added {$item['title']} to {$place->name}\n";
        } catch (\Exception $e) {
            echo "Error adding to {$place->name}: " . $e->getMessage() . "\n";
        }
    }
}

echo "Done seeding nearby hotels for all places.\n";
