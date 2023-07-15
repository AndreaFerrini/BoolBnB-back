<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Apartment as Apartment;
use App\Models\Message as Message;

class MessagesTableSeeder extends Seeder
{
    private $max_msgs_per_apartment = 10;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $all_apartments = Apartment::all();
        foreach ($all_apartments as $apartment)
        {
            for ($counter = 0; $counter < $this->max_msgs_per_apartment; $counter++)  
            {
                $is_there_msg = (bool) mt_rand(0,3);
                if (!$is_there_msg)
                    break;
                else
                {
                    $name = $faker->randomElement(["Andrea", "Michele", "Riccardo", "Edoardo", "Leonardo", "Luca", "Maria", "Antonio", "Angela"]);
                    $surname = $faker->randomElement(["Rossi", "Bianchi", "Rinaldi", "Penco", "Verdi", "Napolitano"]);
                    $random_length = mt_rand(1, 3);
                    $email_body = "";
                    for ($i = 0; $i < $random_length; $i++)
                        $email_body .= $faker->paragraph($nbSentences = 3, $variableNbSentences = true);
                    $apartment->messages()->create( 
                        [
                            'name'          => $name,
                            'surname'       => $surname,
                            'email'         => $name . "." . $surname . "@" . $faker->randomElement(['google.com', 'yahoo.com', 'libero.it']),
                            'email_body'    => $email_body
                        ]);
                }
            }          
        }
    }
}
