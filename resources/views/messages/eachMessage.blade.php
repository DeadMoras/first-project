@extends('main')

@section('title', "Ваше сообщение от пользователя $each->login")

@section('metaContent', 'Бесплатно чтение рецензий, аниме рецензии, читайте и наслаждайтесь.')

@section('metaImg', 'http://animereviews.ru/logo.png')

@section('content')

     <div class="content">
     	 <div class="mainMessages">
                        <div data-id="{{ $each->message_id }}" class="mainMessagesEach">
                                <div class="mainMessagesEachTitle">
                                     <span>Сообщение от пользователя <a href="/user/id{{$each->id}}" style="color: #fff">{{ $each->login }}</a></span>
                                </div>
                                <div class="mainMessagesEachAvatar">
                                    <img src="{{ asset('/uploads/users/'.$each->avatar) }}" alt="">
                                </div>
                                <p class="mainMessagesEachMessage">
                                    {{ $each->message }}
                                </p>
                                {!! Form::open(['route' => 'sendMessage']) !!}

                                <input type="hidden" name="from_id_user" value="{{ $each->from_user }}">

                                {!! Form::textarea('sendMessageFromMessage', null, ['placeholder' => 'Ответ на сообщение...']) !!}

                                {!! Form::submit('Отправить', ['id' => 'sendMessageFromMessages']) !!}

                                {!! Form::close() !!}
                       </div>
        </div>
        <style>
        	.mainMessagesEachMessage {
        		padding-bottom: 10px;
        		border-bottom: solid 2px rgba(0,0,0,.1);
        	}
        </style>
     </div>

@stop