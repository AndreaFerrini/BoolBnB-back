<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment as Apartment;
use App\Models\Sponsor as Sponsor;

class Apartment_SponsorTableSeeder extends Seeder
{
    protected   $max_sponsors_seeding_side  = 10; 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Il ragionamento da fare in questo seeder è il seguente:
        // Nella pivot trovano posto anche le sponsorizzazioni scadute, fornendo materiale utile ai fini statistici.
        // Non necessariamente un appartamento deve avere qualche sponsor ma se ne ha valgono le seguenti regole:
        // Un appartamento può avere anche un'unica sponsorizzazione che potrà essere già scaduta oppure ancora valida.
        // Un appartamento, laddove abbia più sponsorizzazioni, può averne solo una (l'ultima) che sia valida; tutte le altre devono necessariamente essere scadute.
        // Quando una sponsorizzazione scade, il suo campo "expire_at" diventa "null"
        $all_apartments     =   Apartment::All();
        $all_sponsors_ids   =   Sponsor::pluck('id');
        $total_sponsors     =   count($all_sponsors_ids); 
        foreach ($all_apartments as $apartment)
        {
            $exit_loop = false;
            $counter = 0;
            do
            {
                $with_sponsor = mt_rand(0, $total_sponsors);
                if ($with_sponsor == 0)
                    $exit_loop = true;
                else
                {
                    $counter++;
                    $sponsor = Sponsor::find($all_sponsors_ids[$with_sponsor - 1]);
                    $is_expired = (bool) mt_rand(0,1);
                    if (!$is_expired)
                    {
                        $expire_date = \Carbon\Carbon::now()->addHours($sponsor->period)->toDateTimeString();
                        $data = ['expire_at' => $expire_date];
                        $apartment->sponsors()->syncWithoutDetaching([$sponsor->id => $data]);
                        $exit_loop = true;
                    }
                    else
                    {
                        $apartment->sponsors()->syncWithoutDetaching([$sponsor->id => ['expire_at' => null]]);
                    }
                }
            }
            while (!$exit_loop && ($counter < $this->max_sponsors_seeding_side));
        }
    }
}
