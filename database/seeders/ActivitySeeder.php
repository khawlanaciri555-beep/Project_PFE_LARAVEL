<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Place;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        Service::where('image', 'like', '%Activiti%')->delete();

        $activities = [
            [
                'place_name' => "Désert d'Agafay",
                'title' => 'Balade à dos de chameau',
                'folder' => 'desert agafay/jmale',
                'type' => 'Activity',
                'price' => 250,
                'description' => 'Profitez d\'une balade authentique à dos de chameau au coucher du soleil dans le désert d\'Agafay.'
            ],
            [
                'place_name' => "Désert d'Agafay",
                'title' => 'Parapente au-dessus d\'Agafay',
                'folder' => 'desert agafay/parachor',
                'type' => 'Experience',
                'price' => 800,
                'description' => 'Vivez des sensations fortes avec un vol en parapente offrant une vue imprenable sur le désert rocailleux.'
            ],
            [
                'place_name' => "Désert d'Agafay",
                'title' => 'Aventure en Quad',
                'folder' => 'desert agafay/qouad',
                'type' => 'Activity',
                'price' => 450,
                'description' => 'Explorez les pistes poussiéreuses d\'Agafay lors d\'une session de quad pleine d\'adrénaline.'
            ],
            [
                'place_name' => 'Quartier de Guéliz',
                'title' => 'Spa & Hammam Traditionnel',
                'folder' => 'Gelize/spa',
                'type' => 'Experience',
                'price' => 350,
                'description' => 'Détendez-vous avec un rituel de hammam traditionnel marocain suivi d\'un massage relaxant.'
            ],
            [
                'place_name' => 'Jardin Majorelle',
                'title' => 'Atelier de Peinture au Jardin',
                'folder' => 'jardan majoril/rasem',
                'type' => 'Workshop',
                'price' => 200,
                'description' => 'Apprenez les techniques de peinture en plein air dans le cadre inspirant du Jardin Majorelle.'
            ],
            [
                'place_name' => 'Jardin Majorelle',
                'title' => 'Session de Yoga',
                'folder' => 'jardan majoril/yoka',
                'type' => 'Activity',
                'price' => 150,
                'description' => 'Une session de yoga apaisante au milieu de la flore exotique du Jardin Majorelle.'
            ],
            [
                'place_name' => 'Jardins de la Ménara',
                'title' => 'Pique-nique Royal',
                'folder' => 'jardn menara/picnic',
                'type' => 'Experience',
                'price' => 150,
                'description' => 'Savourez un pique-nique traditionnel sous les oliviers séculaires de la Ménara.'
            ],
            [
                'place_name' => 'Vallée de l\'Ourika',
                'title' => 'Cours de Cuisine Berbère',
                'folder' => 'orika/coking',
                'type' => 'Workshop',
                'price' => 300,
                'description' => 'Apprenez à cuisiner un tajine authentique avec une famille locale au cœur de la vallée de l\'Ourika.'
            ],
            [
                'place_name' => 'Oasiria Water Park',
                'title' => 'Détente & Natation',
                'folder' => 'ouzirya barke/swim',
                'type' => 'Activity',
                'price' => 250,
                'description' => 'Profitez d\'une journée rafraîchissante dans les piscines et les lagons d\'Oasiria.'
            ],
        ];

        foreach ($activities as $act) {
            $place = Place::where('name', 'LIKE', '%' . $act['place_name'] . '%')->first();
            
            if ($place) {
                Service::create([
                    'title' => $act['title'],
                    'type' => $act['type'],
                    'image' => '/storage/Activiti/' . $act['folder'] . '/image.png',
                    'description' => $act['description'],
                    'price' => $act['price'],
                    'rating' => rand(40, 50) / 10,
                    'place_id' => $place->id,
                    'availability' => true,
                    'is_deleted' => false,
                ]);
            }
        }
    }
}
