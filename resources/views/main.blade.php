<!DOCTYPE html>
<html lang="ru" prefix="og: http://ogp.me/ns#" xmlns:fb="http://ogp.me/ns/fb#">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="/favicon.png" type="image/ico">
   <meta name="description" content="@yield('metaContent')">
   <meta name="Keywords" content="@yield('metaKey')"> 
    <meta name="viewport" content="width=device-width">
    <meta property="og:type" content="website">
    <meta property="og:image" content="@yield('metaImg')"/>
    <meta name="yandex-verification" content="34261ae20266bd30" />
    <title>@yield('title')</title>
    @include('_patterns._header2')
</head>
<body>
<script src="{{ asset('js/jquery.js') }}"></script>
    @include('_patterns._header')

    @include('_patterns._messages')
     
    <div class="wrapper">
      <meta name="csrf-token" content="{{ csrf_token() }}" />

        @include('_patterns._search')

        <div class="bannersAboutSite">
            <span>
                    <img src="http://theotakuspot.animeblogger.net/wp-content/uploads/2008/08/Azunyann-300x300.gif" alt="">
                    <div>
                        Ведется активный набор в команду <a href="/">AnimeReviews</a>
                        на должность <br> "рецензента", по всем вопросам
                        пишем <a href="http://vk.com/deadmoras">сюда</a>, спасибо.
                    </div>
            </span>
            <span></span>
        </div>
          
        @yield('content')
        
    </div>
      

    @include('_patterns._footer')

    <div class="modalArchiveMessagesMain">
               <div class="modalArchiveMessages">
                     <div class="modalArchiveMessagesTitle">
	                     <span>Отправка сообщения</span>
	                     <i class="fa fa-times" aria-hidden="true"></i>
                     </div>
                     <textarea name="" id=""></textarea>
                     <button id="sendMessageFromProfileTwo">Отправить</button>
               </div>
     </div>

     <div class="modalHeaderAuthMain">
         <div class="modalHeaderAuth">
             <div class="modalHeaderAuthTitle">
                  <span>Авторизация</span>
                  <i class="fa fa-times" aria-hidden="true"></i>
             </div>
             {!! Form::open(['route' => 'postAuth', 'method' => 'post']) !!}

             {!! Form::email('email', null, ['placeholder' => 'email']) !!}

             {!! Form::password('password', ['placeholder' => 'password']) !!}

             {!! Form::submit('Авторизация', []) !!}

             {!! Form::close() !!}
         </div>
     </div>

     <div class="modalArchiveMessagesMainHistory">
               <div class="modalArchiveMessagesHistory">
                     <div class="modalArchiveMessagesTitle">
                         <span>История переписки</span>
                         <i class="fa fa-times" aria-hidden="true"></i>
                     </div>
                    <ul>
                        
                    </ul>
               </div>
     </div>


</body>
</html>