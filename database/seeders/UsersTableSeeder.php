<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User as User;

class UsersTableSeeder extends Seeder
{
    private $users = [
        [
            'email' => 'prova1@gmail.com',
            'password' => '$2y$10$l16O0IhpKIT6KYDBXseZHOcrv76bkqp3uISjcuRZvC2vBLZq.BfzS',
        ],
        [
            'email' => 'prova2@gmail.com',
            'password' => '$2y$10$l16O0IhpKIT6KYDBXseZHOcrv76bkqp3uISjcuRZvC2vBLZq.BfzS',
        ],
        [
            'email' => 'prova3@gmail.com',
            'password' => '$2y$10$l16O0IhpKIT6KYDBXseZHOcrv76bkqp3uISjcuRZvC2vBLZq.BfzS',
        ],
        [
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$l16O0IhpKIT6KYDBXseZHOcrv76bkqp3uISjcuRZvC2vBLZq.BfzS',
        ],
        [
            'email' => 'guest@gmail.com',
            'password' => '$2y$10$l16O0IhpKIT6KYDBXseZHOcrv76bkqp3uISjcuRZvC2vBLZq.BfzS',
        ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->users as $user)
        {
            $new_user = new User();
            $new_user->email = $user['email'];
            $new_user->password = $user['password'];
            $new_user->save();
        }
    }
}
