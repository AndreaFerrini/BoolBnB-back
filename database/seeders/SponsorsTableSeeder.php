<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sponsor as Sponsor;

class SponsorsTableSeeder extends Seeder
{
    protected   $sponsors = [
                                "names"     =>  [
                                                    "short", "medium", "large"
                                                ],
                                "periods"   =>  [
                                                    24, 72, 144
                                                ],
                                "prices"    =>  [
                                                    2.99, 5.99, 9.99
                                                ]
                            ]; 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($index = 0; $index < count($this->sponsors['names']); $index++)
        {
            $new_sponsor = new Sponsor();
            $new_sponsor->name      = $this->sponsors['names'][$index];
            $new_sponsor->period    = $this->sponsors['periods'][$index];
            $new_sponsor->price     = $this->sponsors['prices'][$index];
            $new_sponsor->save();
        }
    }
}
