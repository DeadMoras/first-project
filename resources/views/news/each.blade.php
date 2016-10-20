@extends('main')

@section('title', $data->title)

@section('metaContent', substr($data->description, 1, 500))

@section('metaKey', "Форум сайте animreviews, форум, $data->title")

@section('metaImg', "http://animereviews.ru/uploads/users/$data->avatar")

@section('content')
	<div class="newsContent">
		<div class="news">
		<div class="eachNews" data-id="{{ $data->news_id }}">
			<div class="eachNewsInfo">
				@if ( Auth::check() )
					@if (Auth::user()->roles == 3 || 2 )
						<span id="titleForNew" contenteditable><a>{{ $data->title }}</a></span>
					@endif
				@else
						<span><a>{{ $data->title }}</a></span>
				@endif
				<div class="eachNewsInfoDate"><? echo App\Http\Controllers\TimerRu::create($data->created_at)->longDate();?></div>
			</div>
			<div class="eachNewsImg">
				<img src="{{ asset('/uploads/users/'.$data->avatar) }}">
				<div class="eachNewsImgRate">
					<span class="rateNewPlus">
						<i class="fa fa-plus" aria-hidden="true" id="likeComment"></i>{{ $data->likes }}
					</span>
					/
					<span class="rateNewMinus">
						<i class="fa fa-minus" aria-hidden="true" id="dislikeComment"></i>{{ $data->dislikes }}
					</span>
				</div>
			</div>
			<div class="eachNewsDescription">{{ $data->description }}</div>
			<div class="eachNewsComments"> 
				<div class="eachNewsCommentsTitle"><i class="fa fa-comments" aria-hidden="true"></i></div> 
				<div id="loadMoreComments">
					
				</div>
				<div id="allCommentsHah">
				</div>
				@if ( Auth::check() )
				<div class="eachNewsCommentsAdd"> 
					<textarea name="commentTextarea" id="commentTextarea" placeholder="Введите ваш комментарий"></textarea> 
					<button>Добавить</button> 
				</div> 
				@endif
			</div>
		</div>
		</div>
		<div class="newsAside">
			<div class="block" id="aboutAuthorNews">
				<div class="blockTitle">Информация об авторе</div>
				<div class="aboutAuthorNewsUser">Логин <span><a href="/user/id{{$data->id}}">{{ $data->login }}</a></span></div>
				<div class="aboutAuthorNewsUser">Вконтакте <span>
					<?
							if ( $data->vk ) echo '<a href="'.$data->vk.'"><i class="fa fa-vk" aria-hidden="true"></i></a>';
							else echo 'Пусто';
					?> 
				</span></div>
				<div class="aboutAuthorNewsUser">Дата регистрации <span><? echo App\Http\Controllers\TimerRu::create($data->created_at)->longDate();?></span></div>
			</div>
		</div>
	</div>	
	
	<script>
		var userId = '@if(Auth::check()){{Auth::user()->id}}@endif';
		var skip, offset = 0;
		var newsId = '{{$data->news_id}}';

		function getCommentsEachHews() {
			var that = $(this);
			$.ajax({
				method: 'get',
				url: '/each_news_comments',
				dataType: 'json',
				beforeSend: function() {
					$('.eachNewsCommentsMore').remove();
				},
				data: { 
					skip: skip,
					newsId: newsId
				},
				success: function(data) {
					offset++;
			                          skip = offset * 20;
			                         if ( data.data.length >= 20 ) {
				                         $('#loadMoreComments').append('<div class="eachNewsCommentsMore" onclick="getCommentsEachHews();">Загрузить еще</div>');
			                         }
			                         $.each(data.data, function() {
				                         var comm = '';

				                         comm += '<div class="eachNewsCommentsView';
				                         if ( this.likes && this.dislikes > 10 ) {
					                         	if ( this.likes < (this.dislikes + 2) ) {
					                         		comm += ' eachNewsCommentsViewHidden"';
					                         	}
				                         } else {
					                         	comm += '"';
				                         }
				                         comm += 'data-id="'+ this.news_comments_id +'">';
				                         comm += '<img src="/uploads/users/'+ this.avatar +'">';
				                         comm += '<span id="answerLoginUser"><a href="/user/id'+ this.user_id +'">'+ this.login +'</a></span> ';
			                          if ( userId ) {
				                         if ( userId != this.user_id ) {
					                         comm += '<i class="eachnewsCommentsReply fa fa-reply" aria-hidden="true" data-id="'+ this.user_id +'"></i>';
				                         }
			                          }
				                         comm += '<div class="eachNewsCommentsViewLikes">';
				                         comm += '<span class="eachNewsCommentsViewLikesLike"><i class="fa fa-thumbs-up" aria-hidden="true"></i>'+ this.likes +'</span>';
				                         comm += '/';
				                         comm += '<span class="eachNewsCommentsViewLikesDislike"><i class="fa fa-thumbs-down" aria-hidden="true"></i>'+ this.dislikes +'</span>';
				                         comm += '</div>';
				                         if (  this.to_user_id == userId ) {
					                         comm += '<div class="eachNewsCommentsViewDescription answerForUserInNews"><span>#'+ '@if(Auth::check()){{Auth::user()->login}}@endif' + ', </span>' + this.comment_body +'</div>';
				                         } else {
					                         comm += '<div class="eachNewsCommentsViewDescription">'+ this.comment_body +'</div>';
				                         }
				                         comm += '</div>';

				                         $('#allCommentsHah').append(comm);
			                         });
				}
			});
		};

		$('#allCommentsHah').on('click', '.eachNewsCommentsViewLikes span', function() {
			var likeableComment = $(this).attr('class');
			var likeComment = $(this).parent();
			var idCommentLike = $(this).parent().parent().data('id');
			$('.eachnewsCommentsReply').fadeIn('fast');

		if ( userId ) {
				
			$.ajax({
				method: 'post',
				url: '/new_comment_likes',
				dataType: 'json',
				data: {
					likeableComment: likeableComment,
					idCommentLike: idCommentLike,
					userId: userId
				},
				success: function(data) {
					if ( data.success ) {
						likeComment.fadeOut();
					} else {
						pushNotifications('successJsButtonError', data.error)
					}
				}
			});

		} else {
			pushNotifications('successJsButtonError', 'Авторизуйтесь, чтобы оценивать');
		}
			});

		function sendEachComment() {
			$('.eachNewsCommentsAdd').on('click', 'button', function() {
				var commentHey = $(this).parent().find('textarea').val();
				var answerTouUserId = $(this).parent().find('.replyToAnswerNews').data('id');

				if ( commentHey.length > 0 ) {
					$.ajax({
						method: 'post',
						url: '/new_comment_news',
						dataType: 'json',
						data: {
							newsId: newsId,
							commentHey: commentHey,
							userId: userId,
							answerTouUserId: answerTouUserId
						},
						success: function(data) {
							if ( data.success ) {
								  var commy = '';

						                         commy += '<div class="eachNewsCommentsView" data-id="'+ data.success.news_comments_id +'">';
						                         commy += '<img src="/uploads/users/'+ data.success.avatar +'">';
						                         commy += '<span><a href="/user/id'+ data.success.user_id +'">'+ data.success.login +'</a></span> ';
						                         commy += '<div class="eachNewsCommentsViewDescription">'+ data.success.comment_body +'</div>';
						                         commy += '</div>';

						                         $('#allCommentsHah').append(commy);
						                        $('#commentTextarea').val('');
							} else {
								pushNotifications('successJsButtonError', data.error);
							}
						}
					});
				} else {
					pushNotifications('successJsButtonError', 'Нельзя отправлять пустые комментарии');
				}
			});
		};

		$('#titleForNew').blur(function() {
			var newTitleForNew = $(this).text();
			var newTitleForNewId = $(this).parent().parent().data('id');

			$.ajax({
				method: 'post',
				url: '/editTitle',
				data: {
					newTitleForNew: newTitleForNew,
					newTitleForNewId: newTitleForNewId,
					userId: userId
				},
				success: function(data) {
					if ( data.success ) pushNotifications('successJsButtonSuccess', data.success);
					else pushNotifications('successJsButtonError', data.error);
				}
			});
		});

		$('#allCommentsHah').on('click', '.eachnewsCommentsReply', function() {
			var that = $(this);
			$('.eachnewsCommentsReply').fadeOut('fast');
			var answerUserId = that.data('id');
			var answerUserLogin = that.parent().find('#answerLoginUser').text();

			that.parent().parent().parent().find('.eachNewsCommentsAdd').append('<div class="replyToAnswerNews" data-id="'+ answerUserId +'">Вы отвечаете на сообщение юзера <span style="color: #b07171">'+ answerUserLogin +'</span><i class="removeReplyToAnswer fa fa-times" aria-hidden="true"></i></div> ');
			that.parent().parent().parent().find('.eachNewsCommentsAdd').on('click', '.removeReplyToAnswer', function() {
				$(this).parent().fadeOut();
			});

		});

		$(document).ready(function() {
			sendLikeComment();
			getCommentsEachHews();
			sendEachComment();
		});		
	</script>

@stop