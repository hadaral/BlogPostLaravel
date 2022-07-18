<?php

namespace App\Observers;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Support\Facades\Cache;

class CommentObserver
{
    public function creating(Comment $comment){
        // dd("I am created!");
        if($comment->commentable_type == BlogPost::class){
            Cache::tags(['blog-post'])->forget("blog-post-{$comment->commentable_id}"); //because blog post comments was change and we have somthing to add
            Cache::tags(['blog-post'])->forget('mostCommented');
        }
    }
}
