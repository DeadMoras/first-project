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
			{!! Form::open(['route' => ['adminEditReview', $review->id], 'class' => 'adminContainerRightEditReview', 'files' => true]) !!}

			{!! Form::text('title', $review->title, []) !!}
			
			{!! Form::text('slowtitle', $review->slowtitle, []) !!}

			{!! Form::file('img_review', []) !!}

			{!! Form::select('cats', $cats, $review->cat_id, ['class' => 'form-control']) !!}

			<img src="/uploads/reviews/{{$review->img_review}}" alt="">

			{!! Form::textarea('forindex', $review->forindex, []) !!}
			
			{!! Form::textarea('about', $review->about, []) !!}

			{!! Form::textarea('bodyindex', $review->bodyindex, []) !!}

			{!! Form::text('userAuthor', $review->user_id, []) !!}

			{!! Form::submit('Обновить', []) !!}

			{!! Form::close() !!}
		</div>
	</div>