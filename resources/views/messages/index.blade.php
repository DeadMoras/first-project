@extends('main')

@section('title', 'Личные сообщения')

@section('metaContent', 'Бесплатно чтение рецензий, аниме рецензии, читайте и наслаждайтесь.')

@section('metaImg', 'http://animereviews.ru/logo.png')

@section('content')

     <div class="content">
        <div class="mainMessages">
                  <ul>
                    @foreach ( $messages as $m )
                        <li data-id="{{ $m->message_id }}" class="mainMessagesEach">
                             <input type="hidden" id="readedMessage" value="{{$m->readed}}">
                                <div class="mainMessagesEachTitle">
                                     <span>Сообщение от пользователя <a href="/user/id{{$m->id}}" style="color: #fff">{{ $m->login }}</a></span>
                                     <a href="{{ route('messageEach', $m->message_id) }}" id="eachMessageBlank"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                     <i class="delete fa fa-trash" aria-hidden="true"></i>
                                </div>
                                <div class="mainMessagesEachAvatar">
                                    <img src="{{ asset('/uploads/users/'.$m->avatar) }}" alt="">
                                </div>
                                <p class="mainMessagesEachMessage">
                                   {{ $m->message }}
                                </p>
                       </li>
                       @endforeach
                  </ul>
        </div>
     </div>

      <script>
      $(document).ready(function() {

         $('.mainMessages ul li').on('click', '.delete', function() {
                   var that = $(this);
                   var messageId = that.parent().parent().data('id');

                   $.ajax({
                       method: 'post',
                       url: '/delete_message',
                       dataType: 'json',
                       data: {
                           messageId: messageId,
                       },
                       success: function(data) {
                           if ( data.success ) {
                               that.parent().parent().fadeOut('normal');
                               pushNotifications('successJsButtonSuccess', data.success);
                           } else {
                              pushNotifications('successJsButtonError', data.error);
                           }
                       }
                   });
         });

         $('.mainMessages ul').on('click', 'li #eachMessageBlank', function(data) {
               var that = $(this);
               var readedMessage = that.parent().parent().find('#readedMessage').val();
               var idMessage = that.parent().parent().data('id');

               if ( readedMessage == 1 ) {
                     $.ajax({
                         method: 'post',
                         url: '/readed_message',
                         dataType: 'json',
                         data: {
                             idMessage: idMessage
                         },
                         success: function(data) {
                             
                         }
                     })
               }
         });

          var skipM = 20,
                 offsetM = 0;
           $(window).scroll(function() 
            {
              if  ($(window).scrollTop() == $(document).height() - $(window).height()) 
              {
                 $.ajax({
                     method: 'get',
                     url: '/moreMessages',
                     dataType: 'json',
                     data: {
                         skipM: skipM
                     },
                     success: function(data) {
                         offsetM++;
                         skipM = offsetM * 40;

                         $.each(data.more, function() {
                              var moreM = '';

                              moreM += '<li data-id="'+ this.message_id +'" class="mainMessagesEach">';
                              moreM += '<input type="hidden" id="readedMessage" value="'+ this.readed +'">';
                              moreM += '<div class="mainMessagesEachTitle">';
                              moreM += '<span>Сообщение от пользователя <a href="/user/id'+ this.id +'" style="color: #fff">'+ this.login +'</a></span>';
                              moreM += '<a href="/message/'+ this.message_id +'" id="eachMessageBlank"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
                              moreM += '<i class="delete fa fa-trash" aria-hidden="true"></i>';
                              moreM += '</div>';
                              moreM += '<div class="mainMessagesEachAvatar"><img src="/uploads/users/'+ this.avatar +'" alt=""></div>';
                              moreM += '<p class="mainMessagesEachMessage">'+ this.message +'</p>';
                              moreM += '</li>';

                              $('.mainMessages ul').append(moreM);
                         });
                     }
                 });
              }
            });

     });
     </script>

@stop