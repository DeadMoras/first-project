@extends('main')

@section('title', 'Уведомления. Notifications')

@section('metaContent', 'Уведомления на сайте. Бесплатно чтение рецензий, аниме рецензии, читайте и наслаждайтесь.')

@section('metaImg', 'http://animereviews.ru/logo.png')

@section('content')

     <div class="content">
      <div class="notificationsPage">
        <div class="notificationsPageSubscribed">
            <div class="notificationsPageSubscribedTitle">Вы подписаны</div>
          <ul>
                                                    @if ( count($not) > 0 )
                                                         @foreach ( $not as $n )
            <li>
                                                                             <a href="/user/id{{$n->id}}">
              <img src="{{ asset('/uploads/users/'.$n->avatar) }}" alt="">
              <span>{{ $n->login }}</span>
                                                                              </a>
            </li>
                                                           @endforeach
                                                           @else 
                                                             <li>Вы сильный и независимый.</li>
                                                       @endif
          </ul>
        </div>
        <div class="notificationsPageNotifications">
             <div class="notificationsPageNotificationsTitle">Ваши уведомления</div>
          <ul>
                                                       @foreach ( $data as $d )
            <li data-id="{{$d->id}}">
                                                                      {!! $d->title !!}
                          <span id="deleteNotify"><i class="fa fa-trash" aria-hidden="true"></i></span>
                                                                 @if ( $d->readed == 1 )
                                                                      <span id="readNotify"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                                                 @endif
            </li>
                 @endforeach
          </ul>
        </div>
      </div>
     </div>

     <script>
          $(document).ready(function() {
                $('.notificationsPageNotifications').on('click', '#readNotify', function() {
                     var that = $(this);
                     notifyId = that.parent().data('id');

                     $.ajax({
                            method: 'post',
                            url: '/profile/notifications_readed',
                            dataType: 'json',
                            data: {
                                 notifyId: notifyId
                            },
                            success: function(data) {
                                 if ( data.success ) {
                                       that.css({
                                           right: '100px'
                                       }, 500).fadeOut('normal');
                                 } else {
                                      console.log('error');
                                 }
                            }
                     });
                });
                 $('.notificationsPageNotifications').on('click', '#deleteNotify', function() {
                     var that = $(this);
                     notId = that.parent().data('id');

                     $.ajax({
                            method: 'post',
                            url: '/profile/notifications_delete',
                            dataType: 'json',
                            data: {
                                 notId: notId
                            },
                            success: function(data) {
                                 if ( data.success ) {
                                       that.parent().css({
                                           right: '100px'
                                       }, 500).fadeOut('normal');
                                 } else {
                                      console.log('error');
                                 }
                            }
                     });
                });
                
          });
     </script>
@stop
