<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersCount = (int)$this->command->ask('How many users would you like?',20,1);
        User::factory()->userJohnDoe()->create();
        User::factory()->count($usersCount)->create();

        // $users = $otherUsers->concat([$doe]);
    }
}
