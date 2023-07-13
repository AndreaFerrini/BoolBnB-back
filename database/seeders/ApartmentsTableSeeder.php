<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Apartment as Apartment;
use App\Models\Service as Service;

require_once __DIR__ . '../../../../../config/Data_For_Seeding/bnb_api_client_functions.php';
require_once __DIR__ . '../../../../../config/Data_For_Seeding/bnb_database_for_seeding.php';

require_once __DIR__ . '../../../config/Data_For_Seeding/bnb_api_client_functions.php';

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    }
}
