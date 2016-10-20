<?php

namespace App\Listeners;

use App\Events\SubNotify;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubNotifications
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
     * @param  SubNotify  $event
     * @return void
     */
    public function handle(SubNotify $event)
    {
            foreach ( $event as $e ) 
           {
               $notify = new \App\Notifications;
               $notify->user_id = $e->user_id; 
               $notify->title = 'У Вас новый <a href="http://animereviews.ru/user/id'.trim($e->from_user_id).'">подписчик</a>';
               $notify->notifiable = 'App\Subscribe';
               $notify->save();
           }

    }
}
