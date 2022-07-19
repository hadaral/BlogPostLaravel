<?php

namespace App\Http\Controllers;

use App\Events\CommentPosted as EventsCommentPosted;
use App\Http\Requests\StoreComment;
use App\Models\BlogPost;

class PostCommentController extends Controller
{

    public function __construct(){
        $this->middleware('auth')->only(['store']);
    }

    public function index(BlogPost $post){
        return $post->comments;
    }

    public function store(BlogPost $post,StoreComment $request){
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
        ]);

        event(new EventsCommentPosted($comment));

        return redirect()
            ->back()
            ->withStatus('Comment was created!');  //redurect back to the blog post page(to the last page)
        //redurect back to the blog post page(to the last page)
    }
}
