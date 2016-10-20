<?php

namespace App\Listeners;

use App\Events\CommReply;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentReply
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CommReply  $event
     * @return void
     */
    public function handle(CommReply $event)
    {
           foreach ( $event as $e ) {
                  $notify = new \App\Notifications;
                  $notify->user_id = $e->to_user_id;
                  $notify->title = 'Вам ответили в <a href="/show_modal_comment" data-id="'.trim($e->id).'" id="commentOpen">комментарие</a>';
                  $notify->notifiable = 'App\Comments';
                  $notify->save();
           }
    }
}
