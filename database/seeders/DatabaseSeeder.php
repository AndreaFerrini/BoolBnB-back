<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UsersTableSeeder::class]);
        $this->call([ApartmentsTableSeeder::class]);
        $this->call([ServicesTableSeeder::class]);
        $this->call([Apartment_ServiceTableSeeder::class]);
        $this->call([SponsorsTableSeeder::class]);
        $this->call([Apartment_SponsorTableSeeder::class]);
        $this->call([MessagesTableSeeder::class]);
    }
}
