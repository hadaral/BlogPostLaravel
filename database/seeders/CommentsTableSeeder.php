<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\User;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $posts = BlogPost::All();

        if($posts->count() === 0){
            $this->command->info('There are no blog posts, so no comment will be added');
            return;
        }

        $commentsCount = (int)$this->command->ask('How many comments would you like?',150);
        $users = User::All();

        Comment::factory($commentsCount)->make()->each(function($comment) use ($posts,$users){
            $comment->blog_post_id = $posts->random()->id;
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
    }
}
