<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $place_id = 3; // Jardin Majorelle, Marrakech

        $riads = [
            ['title' => 'Riad BE Marrakech', 'type' => 'riad', 'price' => 2500, 'rating' => 4.8, 'desc' => 'Instagram-famous riad with a stunning courtyard.', 'image' => 'https://images.unsplash.com/photo-1549294413-26f195200c16?q=80&w=1000'],
            ['title' => 'Riad Yasmine', 'type' => 'riad', 'price' => 2200, 'rating' => 4.7, 'desc' => 'Iconic green-and-white tiled courtyard.', 'image' => 'https://images.unsplash.com/photo-1590073242678-70ee3fc28e8e?q=80&w=1000'],
            ['title' => 'Riad Kasbah', 'type' => 'riad', 'price' => 1800, 'rating' => 4.6, 'desc' => 'Charming and sophisticated in the medina.', 'image' => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?q=80&w=1000'],
            ['title' => 'Riad Dar des Arts', 'type' => 'riad', 'price' => 1500, 'rating' => 4.9, 'desc' => 'Peaceful fountain-filled patio.', 'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=1000']
        ];

        $hotels = [
            ['title' => 'Royal Mansour', 'type' => 'hotel', 'price' => 15000, 'rating' => 4.9, 'desc' => 'Ultra-luxury property built like a palace.', 'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1000'],
            ['title' => 'La Mamounia', 'type' => 'hotel', 'price' => 12000, 'rating' => 4.8, 'desc' => 'World-famous historic luxury hotel.', 'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=1000'],
            ['title' => 'La Sultana Marrakech', 'type' => 'hotel', 'price' => 7000, 'rating' => 4.7, 'desc' => 'Contemporary oriental luxury near Saadian Tombs.', 'image' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=1000'],
            ['title' => 'Nobu Hotel Marrakech', 'type' => 'hotel', 'price' => 5000, 'rating' => 4.5, 'desc' => 'Modern stylish hotel with rooftop pool.', 'image' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=1000'],
            ['title' => 'Fairmont Royal Palm', 'type' => 'hotel', 'price' => 4500, 'rating' => 4.6, 'desc' => 'Massive golf course and scenic views.', 'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?q=80&w=1000'],
            ['title' => 'Mandarin Oriental', 'type' => 'hotel', 'price' => 9000, 'rating' => 4.7, 'desc' => 'Oasis of luxury with private villas.', 'image' => 'https://images.unsplash.com/photo-1544124499-58912cbddaad?q=80&w=1000']
        ];

        foreach(array_merge($riads, $hotels) as $item) {
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
        }
    }
}
