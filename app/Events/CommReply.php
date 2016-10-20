<?php

namespace App\Events;

use App\Events\Event;
use App\Comments;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommReply extends Event
{
    use SerializesModels;

    public $comments;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comments $comments)
    {
           $this->comments = $comments;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
