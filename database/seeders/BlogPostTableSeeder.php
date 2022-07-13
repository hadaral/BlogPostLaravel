<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\BlogPost;

class BlogPostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $blogsCount = (int)$this->command->ask('How many blogs would you like?',50);

        $users = User::All();
        
        BlogPost::factory($blogsCount)->make()->each(function($post) use ($users){
            $post->user_id = $users->random()->id;
            $post->save();
        });
    }
}
