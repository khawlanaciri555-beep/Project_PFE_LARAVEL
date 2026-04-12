<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Place;

class PlaceSeeder extends Seeder
{
    public function run(): void
    {
        $places = [
            [
                'name' => 'Mosquée Koutoubia',
                'category' => 'Monument',
                'description' => "La plus grande mosquée de Marrakech, célèbre pour son minaret de 77 mètres. Un chef-d'œuvre de l'architecture hispano-mauresque.",
                'coordinates' => '31.6235, -7.9936',
                'image' => '/storage/places/Mosquée Koutoubia/WhatsApp Image 2026-04-06 at 4.02.35 PM (1).jpeg',
                'address' => 'Avenue Mohammed V, Marrakech',
            ],
            [
                'name' => 'Place Jemaa el-Fna',
                'category' => 'Atmosphere',
                'description' => "Le cœur battant de Marrakech. Charmeurs de serpents, conteurs, musiciens et stands de nourriture.",
                'coordinates' => '31.6258, -7.9891',
                'image' => '/storage/places/Place Jemaa el-Fna/WhatsApp Image 2026-04-06 at 4.09.59 PM (1).jpeg',
                'address' => 'Médina, Marrakech',
            ],
            [
                'name' => 'Jardin Majorelle',
                'category' => 'Jardin',
                'description' => "Un jardin botanique luxuriant conçu par l'artiste Jacques Majorelle, célèbre pour son bleu cobalt vif.",
                'coordinates' => '31.6416, -8.0033',
                'image' => '/storage/places/Jardin Majorelle/WhatsApp Image 2026-04-06 at 3.47.16 PM (1).jpeg',
                'address' => 'Rue Yves Saint Laurent, Marrakech',
            ],
            [
                'name' => 'Palais de la Bahia',
                'category' => 'Palais',
                'description' => "Un palais du 19ème siècle magnifiquement décoré avec des mosaïques et des sculptures sur bois.",
                'coordinates' => '31.6217, -7.9816',
                'image' => '/storage/places/Palais de la Bahia/WhatsApp Image 2026-04-06 at 3.39.52 PM (1).jpeg',
                'address' => 'Avenue Imam El Ghazali, Marrakech',
            ],
            [
                'name' => 'Medersa Ben Youssef',
                'category' => 'Culture',
                'description' => "L'une des plus grandes anciennes écoles coraniques d'Afrique du Nord. Architecture époustouflante.",
                'coordinates' => '31.6319, -7.9866',
                'image' => '/storage/places/Medersa Ben Youssef/WhatsApp Image 2026-04-06 at 3.43.06 PM (1).jpeg',
                'address' => 'Kaat Benahid, Marrakech',
            ],
            [
                'name' => 'Les Tombeaux Saadiens',
                'category' => 'Monument',
                'description' => "Des sépultures royales datant de la dynastie saadienne (16ème siècle), redécouvertes en 1917.",
                'coordinates' => '31.6171, -7.9893',
                'image' => '/storage/places/Les Tombeaux Saadiens/WhatsApp Image 2026-04-06 at 4.19.00 PM.jpeg',
                'address' => 'Rue de la Kasbah, Marrakech',
            ],
            [
                'name' => 'Palais el badi',
                'category' => 'Palais',
                'description' => "Des ruines grandioses d'un palais de la fin du 16ème siècle, construit par le sultan Ahmed al-Mansour.",
                'coordinates' => '31.6186, -7.9856',
                'image' => '/storage/places/Palais el badi/WhatsApp Image 2026-04-06 at 4.15.07 PM (1).jpeg',
                'address' => 'Ksibat Nhass, Marrakech',
            ],
            [
                'name' => 'Jardins de la Ménara',
                'category' => 'Jardin',
                'description' => "Un vaste verger d'oliviers avec un grand bassin central du 12ème siècle.",
                'coordinates' => '31.6133, -8.0200',
                'image' => '/storage/places/Jardins de la Ménara/WhatsApp Image 2026-04-06 at 4.29.00 PM (1).jpeg',
                'address' => 'Avenue de la Ménara, Marrakech',
            ],
            [
                'name' => "Désert d'Agafay",
                'category' => 'Adventure',
                'description' => "Un désert rocailleux à seulement 30 km de Marrakech. Parfait pour les promenades à dos de chameau.",
                'coordinates' => '31.3983, -8.1517',
                'image' => "/storage/places/Désert d'Agafay/WhatsApp Image 2026-04-06 at 4.31.51 PM (1).jpeg",
                'address' => "Route d'Amezmiz, Marrakech",
            ],
            [
                'name' => 'Musée Dar Si Said',
                'category' => 'Museum',
                'description' => "Le Musée de l'Artisanat Marocain. Situé dans un magnifique palais, il expose des tapis berbères.",
                'coordinates' => '31.6231, -7.9822',
                'image' => '/storage/places/Musée Dar Si Said/WhatsApp Image 2026-04-06 at 4.34.46 PM (1).jpeg',
                'address' => 'Riad Zitoun Jdid, Marrakech',
            ],
            [
                'name' => 'Musée Yves Saint Laurent',
                'category' => 'Museum',
                'description' => "Un musée fascinant dédié au travail du grand couturier français.",
                'coordinates' => '31.6425, -8.0028',
                'image' => '/storage/places/Musée Yves Saint Laurent/WhatsApp Image 2026-04-06 at 4.56.08 PM (1).jpeg',
                'address' => 'Rue Yves St Laurent, Marrakech',
            ],
            [
                'name' => 'Cyber Park Arsat Moulay Abdeslam',
                'category' => 'Jardin',
                'description' => "Un majestueux parc de 8 hectares datant du 18ème siècle, offrant un mélange de nature et Wi-Fi.",
                'coordinates' => '31.6264, -8.0019',
                'image' => '/storage/places/Cyber Park Arsat Moulay Abdeslam/WhatsApp Image 2026-04-06 at 5.10.55 PM (1).jpeg',
                'address' => 'Avenue Mohammed V, Marrakech',
            ],
            [
                'name' => 'Oasiria Water Park',
                'category' => 'Adventure',
                'description' => "Le premier parc aquatique du Maroc. Dix hectares de piscines et toboggans.",
                'coordinates' => '31.5714, -8.0267',
                'image' => '/storage/places/Oasiria Water Park/WhatsApp Image 2026-04-09 at 5.31.39 PM (1).jpeg',
                'address' => "Route d'Amizmiz, Marrakech",
            ],
            [
                'name' => 'Dar El Bacha - Musée des Confluences',
                'category' => 'Palais',
                'description' => "Un somptueux palais autrefois demeure du Pacha Thami El Glaoui.",
                'coordinates' => '31.6314, -7.9944',
                'image' => '/storage/places/Dar El Bacha - Musée des Confluences/WhatsApp Image 2026-04-06 at 5.00.57 PM (1).jpeg',
                'address' => 'Médina, Marrakech',
            ],
            [
                'name' => 'Parc National du Toubkal',
                'category' => 'Nature',
                'description' => "Protégeant le point culminant de l'Afrique du Nord, le Djebel Toubkal.",
                'coordinates' => '31.0601, -7.9150',
                'image' => '/storage/places/Parc National du Toubkal/WhatsApp Image 2026-04-06 at 5.14.24 PM (1).jpeg',
                'address' => 'Haut Atlas (sud de Marrakech)',
            ],
            [
                'name' => 'Barrage Lalla Takerkoust',
                'category' => 'Nature',
                'description' => "Un lac artificiel paisible idéal pour les sports nautiques et l'évasion.",
                'coordinates' => '31.3614, -8.1311',
                'image' => '/storage/places/Barrage Lalla Takerkoust/WhatsApp Image 2026-04-06 at 5.20.19 PM (1).jpeg',
                'address' => "Province d'Al Haouz (Marrakech)",
            ],
            [
                'name' => "Musée d'Art et de Culture",
                'category' => 'Museum',
                'description' => "Un charmant musée privé offrant de superbes expositions de photographie.",
                'coordinates' => '31.6367, -8.0050',
                'image' => "/storage/places/Musée d'Art et de Culture/WhatsApp Image 2026-04-06 at 5.31.10 PM (1).jpeg",
                'address' => 'Passage Ghandouri, Gueliz',
            ],
            [
                'name' => 'Quartier de Guéliz',
                'category' => 'Atmosphere',
                'description' => "Le visage moderne de Marrakech, connu pour le shopping, les cafés et les galeries.",
                'coordinates' => '31.6347, -8.0069',
                'image' => '/storage/places/Quartier de Guéliz/WhatsApp Image 2026-04-06 at 5.36.56 PM (1).jpeg',
                'address' => 'Gueliz, Marrakech',
            ],
            [
                'name' => 'Souk des Teinturiers',
                'category' => 'Marché',
                'description' => "Le quartier le plus coloré des souks, où l'on teint la laine.",
                'coordinates' => '31.6306, -7.9864',
                'image' => '/storage/places/Souk des Teinturiers/WhatsApp Image 2026-04-06 at 5.39.31 PM (1).jpeg',
                'address' => 'Médina, Marrakech',
            ],
            [
                'name' => 'Trattoria Marrakech',
                'category' => 'Restaurant',
                'description' => "Un restaurant italien de charme célèbre pour sa piscine centrale.",
                'coordinates' => '31.6366, -8.0084',
                'image' => '/storage/places/Trattori Marrakech/WhatsApp Image 2026-04-06 at 6.24.17 PM (1).jpeg',
                'address' => 'Gueliz, Marrakech',
            ],
            [
                'name' => "Vallée de l'Ourika",
                'category' => 'Nature',
                'description' => "Une magnifique vallée verdoyante du Haut Atlas, célèbre pour ses sept cascades.",
                'coordinates' => '31.3283, -7.7333',
                'image' => "/storage/places/Vallée de l'Ourika/WhatsApp Image 2026-04-06 at 4.47.40 PM (1).jpeg",
                'address' => "Montagnes du Haut Atlas",
            ],
            [
                'name' => 'Dar Soukkar',
                'category' => 'Lieu de fête',
                'description' => "Une ancienne sucrerie du XVIe siècle transformée en un lieu événementiel majestueux.",
                'coordinates' => '31.5471, -7.9712',
                'image' => '/storage/places/Dar soukkar/WhatsApp Image 2026-04-06 at 6.28.27 PM.jpeg',
                'address' => "Route d'Ourika, Marrakech",
            ]
        ];

        Place::truncate();

        foreach ($places as $place) {
            Place::create($place);
        }
    }
}
