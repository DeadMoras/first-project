<?php

namespace App\Listeners;

use App\Events\NewReview;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewReviewSub
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
     * @param  NewReview  $event
     * @return void
     */
    public function handle(NewReview $event)
    {
          foreach ( $event as $e ) 
          {
              $notify = \App\Subscribe::where('subscribe.user_id', '=',  $e->user_id)->get();
              
              if ( $notify ) {
                    foreach ($notify as $n)
                    {
                            $notify = new \App\Notifications;
                            $notify->user_id = $n->from_user_id;
                            $notify->title = '<a href="http://animereviews.ru/user/id'.trim($e->user_id) .'">Пользователь</a> добавил <a href="http://animereviews.ru/review/'.$e->slowtitle.'">новую рецензию</a>';
                            $notify->notifiable = 'App\Reviews';
                            $notify->save();                            
                    }
                }
          }
    }
}
