@extends('main')

@section('title', 'Форум сайта animereviews. Свободное общение, обсуждение всех онгоингов, рецензий и не только.')

@section('metaContent', 'Бесплатно чтение рецензий, аниме рецензии, читайте и наслаждайтесь. Форум сайта')

@section('metaKey', "Форум сайте animreviews, форум")

@section('metaImg', 'http://animereviews.ru/logo.png')

@section('content')
	<div class="contentIconsView">
	            <a href="#" id="addNews"><i class="fa fa-external-link" aria-hidden="true"></i></a>
            </div>
	<div class="newsContent">
		<div class="news">
		</div>
		<div class="newsAside">
			<div class="block" id="sorted">
				{{-- <div class="blockTitle">Название блока</div> --}}
				<div>По лайкам <span onclick="byLikes();" id="likesSort"><i class="fa fa-check" aria-hidden="true"></i></span></div>
				<div>По дизлайкам <span onclick="byDislikes();" id="dislikeSort"><i class="fa fa-check" aria-hidden="true"></i></span></div>
			</div>
			{{-- <div class="block">
				<div class="blockTitle">Название блока</div>
			</div> --}}
		</div>
	</div>	

	<div class="addNewsModal">
		<div class="addNewsMain">
			<div class="addNewsMainTitle">
				<span>Добавление новости</span>
				<i class="fa fa-times" aria-hidden="true"></i>
			</div>
			<span id="addNewsForm">
				<input type="text" placeholder="Заголовок" name="newsTitle" id="newsTitle">
				<textarea name="descriptionNews" id="descriptionNews" placeholder="Описание"></textarea>
				<button id="addNewsModal">Добавить</button>
			</span>
		</div>
	</div>

	<script>
		var userId = '@if(Auth::check()){{Auth::user()->id}}@endif';
		var skip, offset = 0;
		var sort = 'new';
		var userRole = '@if(Auth::check()){{Auth::user()->roles}}@endif';
		function getNews() {
			$.ajax({
				method: 'get',
				url: '/newsall',
				data: { skip: skip, sort: sort },
				beforeSend: function () {
			                          $('.more-news').remove();
		                          },
		                          success: function(data) {
			                          offset++;
			                          skip = offset * 20;
			                          $.each(data.news, function() {
			                          	var news = '';

			                          	news += '<div class="eachNews" data-id="'+ this.news_id +'">';
			                          	news += '<div class="eachNewsInfo">';
			                          	news += '<span><a href="/news/'+ this.news_id +'">'+ this.title +'</a></span>';
			                          	if ( userRole === '3' || userRole === '2' ) {
			                          		news += '<i class="deleteTheme fa fa-trash" aria-hidden="true"></i>';
			                          	}
			                          	news += '<div class="eachNewsInfoDate">'+ this.created_at +'</div>';
			                          	news += '</div>';
			                          	news += '<div class="eachNewsImg">';
			                          	news += '<img src="/uploads/users/'+ this.avatar +'">';
			                          	news += '<div class="eachNewsImgRate">';
			                          	news += '<span class="rateNewPlus">';
			                          	news += '<i class="fa fa-plus" aria-hidden="true" id="likeComment"></i>'+ this.likes +'</span>';
			                          	news += '/';
			                          	news += '<span class="rateNewMinus">';
			                          	news += '<i class="fa fa-minus" aria-hidden="true" id="dislikeComment"></i>'+ this.dislikes +'</span>';
			                          	news += '</div>';
			                          	news += '</div>';
			                          	news += '<div class="eachNewsDescription">'+ this.description +'</div>';
			                          	news += '<div class="titleLoadComments" id="showComments">Последние 10 комментариев</div>';
			                          	news += '</div>';

			                          	$('.news').append(news);
			                          });
			                          if ( data.news.length >= 20 ) {
			                          	// $('.news').append('<div class="more-news" onclick="getNews()">Еще новости</div>');
			                          	$(window).scroll(function() 
						{
							if  ($(window).scrollTop() == $(document).height() - $(window).height()) 
							{
								setTimeout(getNews(), 1000);
							}
						});
			                          }
		                          }
			});
		};

			$('.news').on('click', '.deleteTheme', function() {
				var that = $(this);
				var themeId = that.parent().parent().data('id');
				console.log(themeId);

				$.ajax({
					method: 'post',
					url: '/deleteTheme',
					dataType: 'json',
					data: {
						themeId: themeId
					},
					success: function(data) {
						if ( data.success ) {
							pushNotifications('successJsButtonSuccess', data.success);
							that.parent().parent().fadeOut('fast');
						} else {
							pushNotifications('successJsButtonError', data.error);
						}
					}
				});
			});

		(function getCommentsToNews() {
			$('.news').on('click', '#showComments', function() {
				var that = $(this);
				var newId = that.parent().data('id');
				$.ajax({
					method: 'get',
					url: '/comments_to_news',
					dataType: 'json',
					data: {
						newId: newId,
					},
					beforeSend: function () {
				                          $('.eachNewsCommentsMore').remove();
			                          },
					success: function(data) {
						that.animate({}, 500).fadeOut('fast');
						var comments = '';
						comments += '<div class="eachNewsComments">';
						comments += '<div class="eachNewsCommentsTitle"><i class="fa fa-comments" aria-hidden="true"></i></div>';
						if ( data.comments.length > 0 ) {	
						$.each(data.comments, function() {

							comments += '<div class="eachNewsCommentsView">';
							comments += '<img src="/uploads/users/'+ this.avatar +'">';
							comments += '<span>#'+ this.login +'</span>';
							comments += '<div class="eachNewsCommentsViewDescription">'+ this.comment_body +'</div>';
							comments += '</div>';
							});
							comments += '</div>';
						} else {
							comments += 'Комментариев нету';
						}
							that.parent().append(comments);
					}
				});
			});
		})();

			function closeThis() {
				$('.addNewsModal').css('display', 'none').animate({
						opacity: 0
					}, 600)
			};

			$('#addNews').click(function() {
				if ( !userId ) {
					pushNotifications('successJsButtonError',  'Авторизуйтесь, чтобы добавлять новости');
				} else {
				$('.addNewsModal').css('display', 'block').animate({
					opacity: 1
				}, 600);
				$('.addNewsMainTitle i').click(function() {
					closeThis();
				});
				$('#addNewsModal').click(function() {
					closeThis();
				});
				setTimeout($('#addNewsForm').on('click', '#addNewsModal', function() {
					var that = $(this);
					var newsTitle = that.parent().find('input[name="newsTitle"]').val();
					var descriptionNews = that.parent().find('textarea').val();

					    if ( descriptionNews.length > 20 && newsTitle.length >= 10 ) {
						$.ajax({
							method: 'post',
							url: '/add_news',
							dataType: 'json',
							data: {
								newsTitle: newsTitle,
								descriptionNews: descriptionNews,
								userId: userId
							},
							success: function(data) {
								if ( data.success ) {
									window.location.reload();
								} else {
									pushNotifications('successJsButtonError', data.error);
								}
							},
							 error: function(data){
							        var errors = data.responseJSON;
							        console.log(errors);
						             }
						});
					} else {
						pushNotifications('successJsButtonError', 'Не соблюденны правила.');
						return false;
					}
				}), 2000)
			      }
			});

			function byLikes()
			{
				skip = 0;
				offset = 0;
				sort = 'likes';
				$('.news').html('');
				$('#likesSort').toggleClass('sortedActive');
				$('#dislikeSort').removeClass('sortedActive');
				getNews();
			}

			function byDislikes()
			{
				skip = 0;
				offset = 0;
				sort = 'dislikes';
				$('#dislikeSort').toggleClass('sortedActive');
				$('#likesSort').removeClass('sortedActive');
				$('.news').html('');
				getNews();
			}

		$(document).ready(function() {
			getNews();
			sendLikeComment();
		});
	</script>
@stop