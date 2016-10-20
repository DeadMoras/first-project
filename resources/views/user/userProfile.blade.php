@extends('main')

@section('title', "Профиль пользователя $profile->login")

@section('metaContent', "Профиль пользователя $profile->login")

@section('metaKey', "Профиль, animereviews, профиль пользователя $profile->login")

@section('metaImg', "http://animereviews.ru/uploads/users/$profile->avatar")

@section('content')

      <div class="content">
      <div class="profileTitle">
        <span>{{ $profile->login }}</span>
         @if ( Auth::check() )
            @if ( Auth::user()->id != $profile->id )
                 <span><i class="arhiveMessages fa fa-envelope-o" aria-hidden="true"></i></span>
            @endif
          @endif
      </div>
      <div class="profileInfoUser">
        <div class="profileInfoUserLeft">
          <img src=" {{ asset('/uploads/users/'.$profile->avatar) }}" alt="">
                 @if ( Auth::check() )
                    @if ( $profile->id != Auth::user()->id )
                    <button id="sendMessageFromProfile">Написать</button>
                      @if ( !$subscribe )
                           <button id="subscribeFromProfile">Подписаться</button>
                       @else
                   <button class="subscribedFromProfile" id="subscribedFromProfile">Отписаться</button>
                      @endif
                    @endif
                  @endif
        </div>
        <div class="profileInfoUserRight">
                                <div>Дата регистрации: <span><? echo App\Http\Controllers\TimerRu::create($profile->created_at)->longDate();?></span></div>
                                <div>Группа: <span>
                                                            <? switch($profile->roles) {
                                                                       case 0:
                                                                           echo 'Пользователь';
                                                                           break;
                                                                       case 1: 
                                                                           echo 'Редактор';
                                                                           break;
                                                                       case 2: 
                                                                           echo 'Модератор';
                                                                           break;
                                                                       case 3:
                                                                           echo 'Администратор';
                                                                           break;
                                                                   }
                                                            ?>
                                                       </span></div>
                                                    @if ( $profile->about != '' && $profile->about != 'null' )
                                                       <div>Обо мне: <span>{{ $profile->about }}</span></div>
                                                    @endif
                                                        {{-- <div>Количество рецензий: <span>2</span></div> --}}
                                                    @if ( $profile->vk != '' && $profile->vk != 'null' )
                                                        <div>Вконтакте: <span><a href="{{$profile->vk}}"><i class="fa fa-vk" aria-hidden="true"></i></a></span></div>
                                                    @endif
            </div>
              <div class="profileCommentsUser">
                <div class="profileCommentsUserTitle">Комментарии</div>
                <ul>
                @foreach ( $commentsUser as $cu )
                  <li data-id="{{ $cu->id }}">
                    <img src="{{ asset('/uploads/reviews/'.$cu->img_review) }}" alt="">
                    <span>{{ $cu->body }}</span>
                  </li>
                @endforeach
                </ul>
              </div>
            </div>
           </div>
      <script>
                            function sendFromProfi() {
                                       $('#sendMessageFromProfileTwo').click(function() {
                                         var messageFromProfileTextarea = $(this).parent().find('textarea').val();

                                       if ( messageFromProfileTextarea.length > 0 ) {

                                         $.ajax({
                                             method: 'post',
                                             url: '/send_message_profile',
                                             dataType: 'json',
                                             data: {
                                                  messageFromProfileTextarea: messageFromProfileTextarea,
                                                  authUserId: authUserId,
                                                  thisUserId: thisUserId
                                             },
                                             success: function(data) {
                                                  if ( data.success ) {
                                                    pushNotifications('successJsButtonSuccess', data.success);
                                                    $(this).parent().find('textarea').val('');
                                                  } else {
                                                   pushNotifications('successJsButtonError', data.error);
                                                  }
                                             }
                                         })

                                       } else {
                                           pushNotifications('successJsButtonError', 'Вы не ввели текст');
                                       }
                                        $(this).parent().parent().removeClass('modalArchiveMessagesMainShow');
                         })};
                                var authUserId = '@if (Auth::check()){{ Auth::user()->id }}@endif'
                                var thisUserId = '{{$profile->id}}'
                                $('#sendMessageFromProfile').click(function() {
                                     $('.modalArchiveMessagesMain').toggleClass('modalArchiveMessagesMainShow');
                                     $('.modalArchiveMessages').animate({
                                          top: '200px',
                                          left: '400px'
                                     }, 500);
                                     $(this).removeClass('modalArchiveMessagesMainShow');
                                     $('.modalArchiveMessagesTitle').find('i').on('click', function() {
                                          $(this).parent().parent().parent().removeClass('modalArchiveMessagesMainShow');
                                     });
                                });

                                $('.arhiveMessages').click(function() {
                                        $('.modalArchiveMessagesMainHistory').toggleClass('modalArchiveMessagesMainShow');
                                        $('.modalArchiveMessagesHistory').animate({
                                             top: '100px',
                                             left: '400px'
                                        }, 500);
                                        $.ajax({
                                            method: 'get',
                                            url: '/archive_messages',
                                            data: { 
                                                  thisUserId: thisUserId,
                                                  authUserId: authUserId
                                            },
                                            dataType: 'json',
                                            success: function(data) {
                                                 $.each(data.header_messages, function() {
                                                      var history = '';

                                                      history += '<li data-id="'+ this.message_id +'" class="';
                                                      if ( this.from_user == authUserId ) {
                                                        history += 'my-messageHistory">';
                                                      } else {
                                                        history += 'message-notMyHistory">';
                                                      }
                                                      history += '<div class="modalArchiveMessagesHistoryImg">';
                                                      history += '<img src="/uploads/users/'+ this.avatar +'" alt="">';
                                                      history += '</div>';
                                                      history += '<span class="modalArchiveMessagesHistoryMessage">';
                                                      history += this.message;
                                                      history += '</span>';
                                                      history += '</li>';

                                                      $('.modalArchiveMessagesHistory ul').append(history);
                                                 });
                                            }
                                        })
                                        if ( $('.modalArchiveMessagesHistory ul').length > 0 ) $('.modalArchiveMessagesHistory ul').html('');
                                        $('.modalArchiveMessagesTitle').find('i').click(function() {
                                            $(this).parent().parent().parent().removeClass('modalArchiveMessagesMainShow');
                                        });
                                });

                                $('#subscribeFromProfile').on('click', function() {
                                     var that = $(this);

                                     $.ajax({
                                         method: 'post',
                                         url: '/subscribe_user',
                                         dataType: 'json',
                                         data: {
                                             authUserId: authUserId,
                                             thisUserId: thisUserId
                                         },
                                         success: function(data) {
                                             if ( data.success ) {
                                                 pushNotifications('successJsButtonSuccess', data.success);
                                                 that.animate({
                                                    left: '1500px',
                                                    top: '1500px'
                                                 }, 500).fadeOut('fast');
                                                 $('.profileInfoUserLeft').append('<button class="subscribedFromProfile" id="subscribedFromProfile">Отписаться</button>');
                                             } else {
                                                 pushNotifications('successJsButtonError', data.error);
                                             }
                                         }
                                     });
                                });

                                $('#subscribedFromProfile').on('click', function() {
                                   $.ajax({
                                        context: this,
                                         method: 'post',
                                         url: '/subscribed_user',
                                         dataType: 'json',
                                         data: {
                                             authUserId: authUserId,
                                             thisUserId: thisUserId
                                         },
                                         success: function(data) {
                                             if ( data.success ) {
                                                 pushNotifications('successJsButtonSuccess', data.success);
                                                 $(this).animate({}, 500).fadeOut('fast');
                                                 $('.profileInfoUserLeft').append('<button id="subscribeFromProfile">Подписаться</button>');
                                             } else {
                                                 pushNotifications('successJsButtonError', data.error);
                                             }
                                         }
                                     });
                                });
            $(document).ready(function() {
              setTimeout(sendFromProfi(), 3000);
            });
        </script>

@stop