<?php

namespace App\Events;

use App\Events\Event;
use App\Reviews;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewReview extends Event
{
    use SerializesModels;

    public $reviews;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Reviews $reviews)
    {
         $this->reviews = $reviews;
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
