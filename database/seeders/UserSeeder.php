<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'User1',
            'email' => 'userone@example.com',
            'password' => bcrypt('user1'),
        ]);

        User::create([
            'name' => 'User2',
            'email' => 'usertwo@example.com',
            'password' => bcrypt('user2'),
        ]);
    }
}
