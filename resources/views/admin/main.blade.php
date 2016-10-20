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
			<div class="adminContainerRightAll">
				<div class="adminContainerRightAllAboutSite">
					<div class="adminContainerRightAllAboutSiteTitle">Информация про сайт</div>
					<ul>
						<li>Пользователей <span>{{ count($users) }}</span></li>
						<li>Комментариев <span>{{ $cC }}</span></li>
						<li>Рецензий <span>{{ $rC }}</span></li>
						<li>Подписчиков <span>{{ $sC }}</span></li>
					</ul>
				</div>
				<div class="adminContainerRightAllSearch">
					<form action="#" method="post">
					<input type="text" name="search" placeholder="Search" autocomplete="off">
					<button type="submit" id="goSearchUser">Искать</button>
					</form>
				</div>
				<div class="adminContainerRightAllUsers">
						<div class="adminContainerRightAllUsersTitle">Пользователи</div>
					<ul>
						@foreach ( $users as $u )
						<li data-id="{{$u->id}}">
							<span>№ {{ $u->id }}</span>
							<span>{{ $u->login }}</span>
							<span>{{ $u->email }}</span>
							<span>{{ $u->created_at }}</span>
							<span>
								 <? switch($u->roles) {
									   case 0:
										   echo 'Пользователь';
										   break;
									   case 1: 
										   echo 'Редактор';
										   break;
								       case 2: 
									       echo 'Модератор';
									       break;
									   case 3:
										   echo 'Администратор';
										   break;
								       }
							             ?>
							</span>
							<span>127.1.9.1</span>
							<span>
								@if ( $u->vk ) 
								   {{ $u->vk }}
								@else 
								   нету вк
								@endif
							</span>
							<span>
								@if ( $u->about )
								    {{ $u->about }}
								@else
								   про себя нету
								@endif
							</span>
							<a href="#" id="updateInfoUser"><i class="fa fa-pencil-square-o" aria-hidden="true" id="userBlock"></i></a>
						</li>
						@endforeach
					</ul>
					{{ $users->links() }}
					<div class="adminContainerRightAllUsersProfile">
						
					</div>
				</div>
			</div>	
		</div>
	</div>
	<script>
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

		$('#goSearchUser').click(function() {
			var searchText = $('input[name="search"]').val();

			$.ajax({
				method: 'post',
				url: '/admin/user_search',
				dataType: 'json',
				data: {
					searchText: searchText,
					_token: CSRF_TOKEN
				},
				success: function(data) {
					$('.adminContainerRightAllUsers ul').animate({
						left: '400px'
					}, 500).remove();
					$.each(data.search, function() {
						var textU = '<ul>';

						textU += '<li data-id="'+ this.id +'">';
						textU += '<span>'+ this.id +'</span>';
						textU += '<span>'+ this.login +'</span>';
						textU += '<span>'+ this.email +'</span>';
						textU += '<span>'+ this.created_at +'</span>';
						if ( this.roles == 0 ) {
							textU += '<span>Пользователь</span>';
						}
						else if ( this.roles == 1) {
							textU += '<span>Редактор</span>';
						}
						else if ( this.roles == 2 ) {
							textU += '<span>Модератор</span>';
						}
						else  {
							textU += '<span>Администратор</span>';
						}
						if ( this.vk !== null ) {
							textU += '<span>'+ this.vk +'</span>';
						} else {
							textU += '<span>нету вк</span>';
						}
						if( this.about !== null ) {
							textU += '<span>'+ this.about +'</span>'
						} else {
							textU += '<span>про себя нету</span>';
						}
						textU += '<a href="#" id="updateInfoUser"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
						textU += '</li>';
						textU += '</ul>';
						$('.adminContainerRightAllUsers').append(textU);
					});
				}
			});
			if ( $('.adminContainerRightAllSearch ul').length > 0 ) $('.adminContainerRightAllSearch ul').html('');
			return false;
		});

		$('.adminContainerRightAllUsers').on('click', '#updateInfoUser', function() {
			var that = $(this);
			dataIdBlock = that.parent().data('id');

			$.ajax({
				method: 'post',
				url: '/admin/user_edit',
				dataType: 'json',
				data: {
					dataIdBlock: dataIdBlock,
					_token: CSRF_TOKEN
				},
				success: function(data) {
					$('.adminContainerRightAllUsers ul').animate({
						left: '300px',
						opacity: 0.25
					}, 500).fadeOut();
					var userE = '<div class="adminContainerRightAllUsersProfileAvatarOther" data-id="'+ data.user.id +'">';
					userE += '<img src="/uploads/users/'+ data.user.avatar +'" alt="" />';
					userE += '<span>'+ data.user.ip +'</span>';
					userE += '<input type="text" name="roleUser" id="roleUser" value="'+ data.user.roles +'">';
					userE += '<span>'+ data.user.created_at +'</span>';
					userE += '</div>';
					userE += '<div class="adminContainerRightAllUsersProfileLeft">';
					userE += '<input type="text" name="loginUser" id="loginUser" value="'+ data.user.login +'">';
					userE += '<input type="text" name="vkUser" id="vkUser" value="'+ data.user.vk +'">';
					userE += '</div>';
					userE += '<div class="adminContainerRightAllUsersProfileRight">';
					userE += '<input type="text" name="emailUser" id="emailUser" value="'+ data.user.email +'">';
					userE += '<input name="aboutUser" id="aboutUser" value="'+ data.user.about +'"></input>';
					userE += '<button id="updateInfo">Обновить</button>';
					userE += '<button id="deleteUser">Удалить</button>';
					userE += '</div>';
					$('.adminContainerRightAllUsersProfile').append(userE);
				}
			});
		});
		$('.adminContainerRightAllUsersProfile').on('click', '#updateInfo', function() {
			var that = $(this);
			var loginUser = $.trim(that.parent().parent().find('input[name="loginUser"]').val());
			var vkUser = $.trim(that.parent().parent().find('input[name="vkUser"]').val());
			var emailUser = $.trim(that.parent().parent().find('input[name="emailUser"]').val());
			var aboutUser = $.trim(that.parent().parent().find('input[name="aboutUser"]').val());
			var roleUser = $.trim(that.parent().parent().find('input[name="roleUser"]').val());
			var userId = $('.adminContainerRightAllUsersProfileAvatarOther').data('id');

			$.ajax({
				method: 'post',
				url: '/admin/user_update',
				dataType: 'json',
				data: {
					userId: userId,
					loginUser: loginUser,
					vkUser: vkUser,
					emailUser: emailUser,
					aboutUser: aboutUser,
					roleUser: roleUser,
					_token: CSRF_TOKEN
				},
				success: function(data) {
					if ( data.success ) {
						alert('Все норм');
						window.location.reload();
					} else {
						alert(data.error)
					}
				}
			});
		});

		$('.adminContainerRightAllUsersProfile').on('click', '#deleteUser', function() {
			var that = $(this);
			var userId = $('.adminContainerRightAllUsersProfileAvatarOther').data('id');

			$.ajax({
				method: 'post',
				url: '/admin/delete_user',
				dataType: 'json',
				data: {
					userId: userId,
					_token: CSRF_TOKEN
				},
				success: function(data) {
					if ( data.success ) {
						alert('vse norm');
						window.location.reload();
					} else {
						alert('Возникла ошибка');
					}
				}
			});
		});
	</script>
</body>
</html>