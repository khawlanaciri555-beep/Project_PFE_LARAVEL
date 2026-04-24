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
                'description' => 'Embarquez pour une aventure intemporelle à travers les dunes dorées. Cette expérience de 2 heures comprend une halte pour déguster un thé à la menthe traditionnel chez l\'habitant tout en admirant le spectacle flamboyant du soleil se couchant sur les sommets de l\'Atlas. Tenue traditionnelle fournie pour des photos mémorables.'
            ],
            [
                'place_name' => "Désert d'Agafay",
                'title' => 'Parapente au-dessus d\'Agafay',
                'folder' => 'desert agafay/parachor',
                'type' => 'Experience',
                'price' => 800,
                'description' => 'Survolez les paysages lunaires du désert d\'Agafay. Accompagné d\'un instructeur certifié, vous profiterez d\'un vol de 20 à 30 minutes offrant un panorama unique à 360 degrés. Une dose d\'adrénaline pure combinée à la sérénité du ciel marocain. Vidéo de votre vol incluse.'
            ],
            [
                'place_name' => "Désert d'Agafay",
                'title' => 'Aventure en Quad',
                'folder' => 'desert agafay/qouad',
                'type' => 'Activity',
                'price' => 450,
                'description' => 'Domptez le terrain rocailleux d\'Agafay au guidon d\'un quad puissant. Notre guide expert vous emmènera hors des sentiers battus pour découvrir des canyons cachés et des plateaux panoramiques. Briefing de sécurité et équipement complet (casque, lunettes) inclus pour une exploration sans limites.'
            ],
            [
                'place_name' => 'Quartier de Guéliz',
                'title' => 'Spa & Hammam Traditionnel',
                'folder' => 'Gelize/spa',
                'type' => 'Experience',
                'price' => 350,
                'description' => 'Une immersion totale dans le bien-être oriental. Ce rituel complet de 2 heures inclut un gommage au savon noir, un enveloppement à l\'argile (ghassoul) et un massage relaxant à l\'huile d\'argan bio. Un moment de pure détente pour revitaliser votre corps et votre esprit au cœur de Guéliz.'
            ],
            [
                'place_name' => 'Jardin Majorelle',
                'title' => 'Atelier de Peinture au Jardin',
                'folder' => 'jardan majoril/rasem',
                'type' => 'Workshop',
                'price' => 200,
                'description' => 'Laissez s\'exprimer l\'artiste en vous dans le bleu iconique du Jardin Majorelle. Cet atelier de 3 heures, animé par un artiste local, vous apprend à capturer la lumière et les couleurs vibrantes de la flore exotique. Tout le matériel (toiles, pinceaux, peinture) est fourni. Vous repartez avec votre propre chef-d\'œuvre.'
            ],
            [
                'place_name' => 'Jardin Majorelle',
                'title' => 'Session de Yoga',
                'folder' => 'jardan majoril/yoka',
                'type' => 'Activity',
                'price' => 150,
                'description' => 'Retrouvez l\'équilibre intérieur lors d\'une séance de yoga Vinyasa au lever du soleil. Pratiquée dans les recoins les plus paisibles du jardin, cette session combine respiration profonde et postures douces pour une harmonie parfaite avec la nature environnante. Tapis de yoga et jus de fruits frais offerts.'
            ],
            [
                'place_name' => 'Jardins de la Ménara',
                'title' => 'Pique-nique Royal',
                'folder' => 'jardn menara/picnic',
                'type' => 'Experience',
                'price' => 150,
                'description' => 'Vivez un moment de grâce à la marocaine. Nous installons pour vous un tapis berbère, des coussins confortables et une table basse sous les oliviers millénaires. Le menu inclut une sélection de salades marocaines, un tajine au choix, des fruits de saison et le thé cérémoniel. Un cadre idyllique pour se ressourcer.'
            ],
            [
                'place_name' => 'Vallée de l\'Ourika',
                'title' => 'Cours de Cuisine Berbère',
                'folder' => 'orika/coking',
                'type' => 'Workshop',
                'price' => 300,
                'description' => 'Plus qu\'un simple cours, une rencontre humaine au cœur des montagnes. Après avoir cueilli vos propres herbes aromatiques dans le jardin potager, vous apprendrez les secrets du dosage des épices et de la cuisson lente au feu de bois. Dégustation de votre préparation face à la vue imprenable sur la vallée.'
            ],
            [
                'place_name' => 'Oasiria Water Park',
                'title' => 'Détente & Natation',
                'folder' => 'ouzirya barke/swim',
                'type' => 'Activity',
                'price' => 250,
                'description' => 'Évadez-vous dans cette oasis de fraîcheur de 10 hectares. Avec ses 8 piscines, sa rivière lente et ses jardins luxuriants, Oasiria offre le cadre parfait pour une journée en famille ou entre amis. Accès illimité aux toboggans et espaces de détente ombragés.'
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
