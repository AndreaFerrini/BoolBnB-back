<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User as User;
use App\Models\Apartment as Apartment;
use Illuminate\Support\Str;

require_once __DIR__ . '../../../config/Data_For_Seeding/bnb_api_client_functions.php';
require_once __DIR__ . '../../../config/Data_For_Seeding/bnb_database_for_seeding.php';

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $all_users = User::all();
        $users_ids_array = [];
        foreach ($all_users as $user)
        {
            $users_ids_array[] = $user->id;
        }
        $all_apartments_data = config('Data_For_Seeding.bnb_database_for_seeding');
        foreach ($all_apartments_data as $apartment_data)
        {
            $json_response = get_coordinates($apartment_data['address'] . " " . $apartment_data['zipcode'], $apartment_data['city']);
            $decoded_response = json_decode($json_response,true);
            if (!isset($decoded_response['results'][0]))
                continue;
            else
                $first_result = $decoded_response['results'][0];
            $id_index = mt_rand(0, count($users_ids_array) - 1);
            $new_apartment = new Apartment();
            $new_apartment->user_id = $users_ids_array[$id_index];
            $new_apartment->longitude = floatval($first_result['position']['lon']);
            $new_apartment->latitude = floatval($first_result['position']['lat']);
            $new_apartment->title = $apartment_data['name'];
            $new_apartment->slug = Str::slug($new_apartment->title);
            $new_apartment->address = $apartment_data['address'] . " " . $apartment_data['zipcode'];
            $new_apartment->city = $apartment_data['city'];
            $new_apartment->cover_img = 'https://picsum.photos/id/237/200/300';
            $new_apartment->description = "e industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book";
            $new_apartment->number_of_rooms = mt_rand(1,4);
            $new_apartment->number_of_bathrooms = mt_rand(1,4);
            $new_apartment->square_meters = mt_rand(15,40);
            $new_apartment->price = mt_rand(1000, 99000) / 100;
            $new_apartment->save();
        }
    }
}
