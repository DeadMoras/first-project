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
			<div class="adminContainerRightCommentsSearch">
					<form action="#" method="post">
					<input type="text" name="search" placeholder="Search" autocomplete="off">
					<button type="submit" id="goSearchUser">Искать</button>
					</form>
			</div>
			<div class="adminContainerRightCommentsAll">
			     <div class="adminContainerRightCommentsAllTitle">Все комментарии</div>
				<ul>
				     @foreach ($allComments as $ac)
					<li data-id="{{$ac->comment_id}}">
						<div class="adminContainerRightCommentsAllImg">
							<a href="/user/id{{$ac->id}}">
							      <img src="{{ asset('/uploads/users/'.$ac->avatar) }}" alt="">
							 </a>
							<div style="padding-left: 20px;">{{ $ac->review_id }}</div>
						</div>
						<span class="adminContainerRightCommentsAllComment">
							{{ $ac->body }}
						</span>
						<div class="adminContainerRightCommentsAllIcons">
							<i class="fa fa-trash" aria-hidden="true" id="commentDelete"></i>
							<i class="fa fa-pencil-square-o" aria-hidden="true" id="commentEdit"></i>
						</div>
					</li>
				        @endforeach
				        {{ $allComments->links() }}
				</ul>
			</div>
		</div>
	</div>
	<script>
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

		$('#goSearchUser').click(function() {
			var searchText = $('input[name="search"]').val();

			$.ajax({
				method: 'post',
				url: '/admin/comments_search',
				dataType: 'json',
				data: {
					searchText: searchText,
					_token: CSRF_TOKEN
				},
				success: function(data) {
					$('.adminContainerRightCommentsAll ul').animate({
						left: '400px'
					}, 500).remove();
					$.each(data.search, function() {
						var textU = '<ul>';

						textU += '<li data-id="'+ this.comment_id +'">';
						textU += '<div class="adminContainerRightCommentsAllImg">';
						textU += '<a href="/user/id'+ this.id +'"> ';
						textU += '<img src="/uploads/users/'+ this.avatar +'" alt=""></a>';
						textU += '<div style="padding-left: 20px;">'+ this.review_id +'</div>';
						textU += '</div>';
						textU += '<span class="adminContainerRightCommentsAllComment">';
						textU += this.body;
						textU += '</span>';
						textU += '<div class="adminContainerRightCommentsAllIcons">';
						textU += '<i class="fa fa-trash" aria-hidden="true" id="commentDelete"></i>';
						textU += '<i class="fa fa-pencil-square-o" aria-hidden="true" id="commentEdit"></i>';
						textU += '</div>';
						textU += '</li>';
						textU += '</ul>';
						$('.adminContainerRightCommentsAll').append(textU);
					});
				}
			});
			if ( $('.adminContainerRightAllSearch ul').length > 0 ) $('.adminContainerRightAllSearch ul').html('');
			return false;
		});

		$('.adminContainerRightCommentsAll').on('click', '#commentDelete', function() {
			var that = $(this);
			var commentId = that.parent().parent().data('id');

			$.ajax({
				method: 'post',
				url: '/admin/comments/delete_comment',
				dataType: 'json',
				data: {
					commentId: commentId,
					_token: CSRF_TOKEN
				},
				success: function(data) {
					if ( data.success ) {
						that.parent().parent().animate({
							left: '400px',
							opacity: 0.4
						}, 500).fadeOut('normal');
					} else {
						alert('error');
					}
				}
			});
		});

		$('.adminContainerRightCommentsAll').on('click', '#commentEdit', function() {
			var that = $(this)
			var commentId = that.parent().parent().data('id');
			
			$.ajax({
				method: 'post',
				url: '/admin/comments/edit_comment',
				dataType: 'json',
				data: {
					commentId:commentId,
					_token: CSRF_TOKEN
				},
				success: function(data) {
					that.parent().parent().find('.adminContainerRightCommentsAllComment').remove();
					that.parent().parent().append('<span class="adminContainerRightCommentsAllComment"><textarea name="" id="">'+ data.comment.body +'</textarea> <button id="sendCommentSave">Ок</button></span>')
					$('.adminContainerRightCommentsAll').on('click', '#sendCommentSave', function() {
						var newMessage = that.parent().parent().find('textarea').val();
						
						$.ajax({
							method: 'post',
							url: '/admin/comments/save_new_comment',
							dataType: 'json',
							data: {
								commentId: commentId,
								newMessage: newMessage,
								_token: CSRF_TOKEN
							},
							success: function(data) {
								if ( data.success ) {
									window.location.reload();
								} else {
									alert('error');
								}
							}
						})
					});
				} 
			})
		});
	</script>
</body>
</html>