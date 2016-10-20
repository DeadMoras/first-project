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
		<button class="adminContainerRightButtonAddReview"><a href="/admin/reviews/add">Добавить рецензию</a></button>
			<div class="adminContainerRightCommentsSearch">
					<form action="#" method="post">
					<input type="text" name="search" placeholder="Search" autocomplete="off">
					<button type="submit" id="goSearchUser">Искать</button>
					</form>
			</div>
			<div class="adminContainerRightReviewsAll">
			     <div class="adminContainerRightReviewsAllTitle">Все рецензии</div>
				<ul>
				     @foreach ( $reviews as $r )
					<li data-id="{{$r->id}}">
						<div class="adminContainerRightReviewsAllImg">
						         <a href="/review/{{$r->slowtitle}}">
							<img src="{{ asset('/uploads/reviews/'.$r->img_review) }}" alt="">
						         </a>
							<div>{{ $r->countrait }} лайков</div>
						</div>
						<span class="adminContainerRightReviewsAllTitleReview">
							{{ $r->title }}
						</span>
						<div class="adminContainerRightReviewsAllIcons">
							<i class="fa fa-trash" aria-hidden="true" id="deleteReview"></i>
							<a href="/admin/reviews/{{$r->id}}/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
						</div>
					</li>
				      @endforeach
				</ul>
				{{ $reviews->links() }}
			</div>
		</div>
	</div>
	<script>
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

		$('#goSearchUser').click(function() {
			var searchText = $('input[name="search"]').val();

			$.ajax({
				method: 'post',
				url: '/admin/reviews_search',
				dataType: 'json',
				data: {
					searchText: searchText,
					_token: CSRF_TOKEN
				},
				success: function(data) {
					$('.adminContainerRightReviewsAll ul').animate({
						left: '400px'
					}, 500).remove();
					$.each(data.search, function() {
						var textU = '<ul>';

						textU += '<li data-id="'+ this.id +'">';
						textU += '<div class="adminContainerRightReviewsAllImg">';
						textU += '<a href="/review/'+ this.id +'"> ';
						textU += '<img src="/uploads/reviews/'+ this.img_review +'" alt=""></a>';
						textU += '<div>'+ this.countrait +'</div>';
						textU += '</div>';
						textU += '<span class="adminContainerRightReviewsAllTitleReview">';
						textU += this.title;
						textU += '</span>';
						textU += '<div class="adminContainerRightReviewsAllIcons">';
						textU += '<i class="fa fa-trash" aria-hidden="true" id="deleteReview"></i>';
						textU += '<a href="/admin/reviews/'+ this.id +'/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
						textU += '</div>';
						textU += '</li>';
						textU += '</ul>';
						$('.adminContainerRightReviewsAll').append(textU);
					});
				}
			});
			if ( $('.adminContainerRightAllSearch ul').length > 0 ) $('.adminContainerRightAllSearch ul').html('');
			return false;
		});

		$('.adminContainerRightReviewsAll').on('click', '#deleteReview', function() {
			var that = $(this);
			reviewId = that.parent().parent().data('id');

			$.ajax({
				method: 'post',
				url: '/admin/reviews_delete',
				dataType: 'json',
				data: {
					reviewId: reviewId,
					_token: CSRF_TOKEN
				},
				success: function(data) {
					if ( data.success ) {
						that.parent().parent().fadeOut('normal');
					} else {
						alert(data.error);
					}
				}
			});
		});
	</script>
</body>
</html>