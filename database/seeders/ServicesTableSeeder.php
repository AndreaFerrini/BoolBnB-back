<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service as Service;

class ServicesTableSeeder extends Seeder
{
    private $services  =  [
        [
            'name' => 'Posto auto',
            'icon' => 'fa-solid fa-square-parking'
        ],
        [
            'name' => 'Ingresso indipendente',
            'icon' => 'fa-solid fa-door-open'
        ],
        [
            'name' => 'Fumatori',
            'icon' => 'fa-solid fa-joint'
        ],
        [
            'name' => 'WiFi',
            'icon' => 'fa-solid fa-wifi'
        ],
        [
            'name' => 'Piscina',
            'icon' => 'fa-solid fa-water-ladder'
        ],
        [
            'name' => 'SPA & Fitness',
            'icon' => 'fa-solid fa-spa'
        ],
        [
            'name' => 'Biciclette',
            'icon' => 'fa-solid fa-bicycle'
        ],
        [
            'name' => 'Ascensore',
            'icon' => 'fa-solid fa-elevator'
        ],
        [
            'name' => 'Accesso disabili',
            'icon' => 'fa-brands fa-accessible-icon'
        ],
        [
            'name' => 'Reception 24 h',
            'icon' => 'fa-solid fa-bell-concierge'
        ],
        [
            'name' => 'Personale multilingua',
            'icon' => 'fa-solid fa-globe'
        ],
        [
            'name' => 'Ristorante',
            'icon' => 'fa-solid fa-utensils'
        ],
        [
            'name' => 'Servizio navetta',
            'icon' => 'fa-solid fa-van-shuttle'
        ],
        [
            'name' => 'Animali ammessi',
            'icon' => 'fa-solid fa-paw'
        ],
        [
            'name' => 'Spiaggia privata',
            'icon' => 'fa-solid fa-umbrella-beach'
        ],
        [
            'name' => 'Bagno in camera',
            'icon' => 'fa-solid fa-toilet'
        ],
        [
            'name' => 'Aria condizionata',
            'icon' => 'fa-solid fa-wind'
        ],
        [
            'name' => 'TV satellitare',
            'icon' => 'fa-solid fa-satellite-dish'
        ],
        [
            'name' => 'Minibar',
            'icon' => 'fa-solid fa-person-skating'
        ],
        [
            'name' => 'Piano cottura',
            'icon' => 'fa-solid fa-kitchen-set'
        ],
        [
            'name' => 'Bollitore',
            'icon' => 'fa-solid fa-mug-hot'
        ],
        [
            'name' => 'Macchina per caffè',
            'icon' => 'fa-solid fa-mug-saucer'
        ],
        [
            'name' => 'Set di cortesia',
            'icon' => 'fa-solid fa-bottle-droplet'
        ],
        [
            'name' => 'Camera insonorizzata',
            'icon' => 'fa-solid fa-volume-xmark'
        ],
        [
            'name' => 'Balcone',
            'icon' => 'fa-solid fa-person-through-window'
        ],
        [
            'name' => 'Vista',
            'icon' => 'fa-solid fa-face-grin-hearts'
        ]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->services as $service)
        {
            $new_service = new Service();
            $new_service->name = $service['name'];
            $new_service->icon = $service['icon'];
            $new_service->save();
        }
    }
}
