<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use App\Subscribe;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SubNotify extends Event
{
    use SerializesModels;

    public $subscribe;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Subscribe $subscribe)
    {
          $this->subscribe = $subscribe;
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
