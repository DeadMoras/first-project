@extends('main')

@section('title', 'Регистрация | Register')

@section('content')

    <div class="register">
 	   <div class="registerTitle">Регистрация
 	          <ol>
 	       	<li id="readRegister">Читать...</li>
 	       	<li>После регистрации Вам будет доступен мини-профиле, который можно вызвать нажав на вашу аватарку в шапке сайта.</li>
 	       	<li>Вы всегда можете добавить/изменить ссылку на Ваш профиль в "вк" зайдя в Ваш профиль и отредактируя его.</li>
 	       	<li>Вы всегда можете добавить/изменить информацию "про Вас". Инструкция выше.</li>
 	         </ol>
 	   </div>
 	   {!! Form::open(['route' => 'postRegister', 'method' => 'post']) !!}

 	   {!! Form::email('email', null, ['placeholder' => 'email']) !!}
 	   
 	   {!! Form::password('password', ['placeholder' => 'password']) !!}

 	   {!! Form::password('password_confirmation', ['class' => 'authinput', 'placeholder' => 'repeat password']) !!}

 	   {!! Form::text('login', '', ['placeholder' => 'login']) !!}

 	   <div class="rightInputsRegister">
 	   
 	   {!! Form::text('vkRegister', null, ['placeholder' => 'Вы вконтакте']) !!}

 	   {!! Form::textarea('aboutMeRegister', null, ['placeholder' => 'Информация про Вас']) !!}

 	   </div>

 	   {!! app('captcha')->display(); !!}

 	   {!! Form::submit('Register', []) !!}

	  {!! Form::close() !!}
    </div>

    <script>
    	$('#readRegister').click(function() {
    		$(this).parent().parent().css('height', 'auto');
    		$(this).fadeOut('fast');
    	});
    </script>
    <style>
    	.modalHeaderAuthMain {
    		margin-top: -57%;
    	}
    </style>

@stop