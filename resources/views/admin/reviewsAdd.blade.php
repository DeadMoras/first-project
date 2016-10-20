<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Здарова чуваааак)</title>
	<link rel="stylesheet" href="{{ asset('/css/main.css') }}">
	<link rel="stylesheet" href="http://animereviews.ru/css/font-awesome.min.css">
	<script src='{{ asset('/js/jquery.js') }}'></script>
</head>
<body>
	<div class="adminContainer">
		<div class="adminContainerLeftProfile">
			@include('admin.leftMenu')
			<meta name="csrf-token" content="{{ csrf_token() }}" />
		</div>
		<div class="adminContainerRight">
			{!! Form::open(['route' => 'adminAddReview', 'class' => 'adminContainerRightEditReview', 'files' => true]) !!}

			{!! Form::text('title', null, ['placeholder' => 'Заголовок']) !!}

			{!! Form::text('slowtitle', null, ['placeholder' => 'Вид ссылки']) !!}

			{!! Form::file('img_review', []) !!}

			{!! Form::select('cats', $cats, null, []) !!}

			{!! Form::textarea('forindex', '', []) !!}

			{!! Form::textarea('about', '
				<p>Дата выхода<span>2016</span></p> 
				<p>Режиссер<span>я</span></p> 
				<p>Тип<span>нету</span></p> 
				<p>Манга<span><a href="#">хз</a></span></p>
			', []) !!}

			{!! Form::textarea('bodyindex', '
				     <div class="contentReviewTopInfoResultReview">
			     	     <div class="contentReviewTopInfoResultReviewTitle">
			     	     	Подводим итоги
			     	     </div>
			     		<div>Сюжет<span>??</span></div>
			     		<div>Рисовка<span>??</span></div>
			     		<div>Музыка<span>??</span></div>
			     		<div>Сообщество<span>??</span></div>
			     	</div>
			', []) !!}

			{!! Form::text('userAuthor', null, ['placeholder' => 'Айди автора']) !!}

			{!! Form::submit('Добавить', []) !!}

			{!! Form::close() !!}
		</div>
	</div>