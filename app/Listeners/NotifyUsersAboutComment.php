<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Jobs\ThrottledMail;
use App\Mail\CommentPostedMarkdown;
use App\Jobs\NotifyUsersPostWasCommented;


class NotifyUsersAboutComment
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CommentPosted $event)
    {
        dd('I was called in response to event');
        //With RateLimit - Redis
        ThrottledMail::dispatch(
            new CommentPostedMarkdown($event->comment), $event->comment->commentable->user)
            ->onQueue('high');

        NotifyUsersPostWasCommented::dispatch($event->comment)
            ->onQueue('low');
    }
}
