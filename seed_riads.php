<?php

use Illuminate\Support\Facades\DB;

$place_id = 3; // Jardin Majorelle
$user = DB::table('users')->first();
$user_id = $user ? $user->id : 1;

// First, delete existing riads for Jardin Majorelle to avoid duplicates
DB::table('services')->where('place_id', $place_id)->where('type', 'Riad')->delete();
DB::table('hotels')->where('type', 'riad')->delete();

$riads = [
    [
        'title' => "Riad Jnane d'Ô", 
        'price' => 1500, 
        'rating' => 4.8, 
        'desc' => "قريب بزاف (حوالي 1.3km)، هادئ وزوين فيه jardin وterrasse.", 
        'image' => 'places/Jardin Majorelle/hebrjomon/riad/Riad Jnane d\'Ô.png'
    ],
    [
        'title' => 'Riad Matham', 
        'price' => 1200, 
        'rating' => 4.7, 
        'desc' => "تقريباً 2km، تقليدي بثمن معقول وفيه rooftop زوين.", 
        'image' => 'places/Jardin Majorelle/hebrjomon/riad/Riad Matham.png'
    ],
    [
        'title' => 'Riad Dar Anika', 
        'price' => 2500, 
        'rating' => 4.9, 
        'desc' => "فاخر شوية، service عالي وcourtyard زوين.", 
        'image' => 'places/Jardin Majorelle/hebrjomon/riad/Riad Dar Anika.png'
    ],
    [
        'title' => 'Riad Yasmine', 
        'price' => 2200, 
        'rating' => 4.8, 
        'desc' => "مشهور بزاف فالـ Instagram، فيه piscine وسط الدار 🌴", 
        'image' => 'places/Jardin Majorelle/hebrjomon/riad/Riad Yasmine.png'
    ]
];

foreach ($riads as $item) {
    try {
        $hotelId = DB::table('hotels')->insertGetId([
            'type' => 'riad',
            'phone' => '+212 524 123 456',
            'email' => str_replace([' ', '\''], '', strtolower($item['title'])) . '@example.com',
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
            'type' => 'Riad',
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
        echo "Inserted " . $item['title'] . "\n";
    } catch (\Exception $e) {
        echo "Error on " . $item['title'] . ": " . $e->getMessage() . "\n";
    }
}
echo "Done seeding riads.\n";
