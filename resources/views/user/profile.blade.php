@extends('main')

@section('title', 'Ваш профиль')

@section('metaContent', "Профиль пользователя $profile->login")

@section('metaImg', "http://animereviews.ru/uploads/users/$profile->avatar")

@section('metaKey', "Профиль, animereviews, профиль пользователя $profile->login")

@section('content')
     <div class="content">
        <div class="profileTitle">
            <span>{{ $profile->login }}</span>
            <span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
        </div>
        <div class="profileInfoUser">
            <div class="profileInfoUserLeft">
                <form method="POST" enctype="multipart/form-data">
                     <input type="file" name="avatarUser" id="avatarUser" class="inputfile" accept=".png, .jpg">
                     <div class="labelForChangeImg"> 
                         <label for="avatarUser" class="labelForChangeImg1"><i class="fa fa-cloud" aria-hidden="true"></i></label>
                    </div>
                 </form>
                <img src="{{ asset('/uploads/users/'.$profile->avatar) }}" alt="">
            </div>
            <div class="profileInfoUserRight">
                <div>Дата регистрации: <span><? echo App\Http\Controllers\TimerRu::create($profile->created_at)->longDate();?></span></div>
                <div>Группа: <span>
                                            <? switch($profile->roles) {
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
                                       </span></div>
                                    @if ( $profile->about )
                                       <div>Обо мне: <span>{{ $profile->about }}</span></div>
                                    @endif
                                        {{-- <div>Количество рецензий: <span>2</span></div> --}}
                                    @if ( $profile->vk )
                                        <div>Вконтакте: <span><a href="{{ $profile->vk }}"><i class="fa fa-vk" aria-hidden="true"></i></a></span></div>
                                    @endif
            </div>
        </div>
     </div>
        <div class="otherInfo"></div>
        <script>
                     $(document).ready(function() {
                         var userId = '{{ Auth::user()->id }}';

                            $('.profileTitle').find('span').find('i').click(function() {
                                        var that = $(this);
                                        that.parent().parent().parent().animate({
                                            right: '1400px',
                                        }, 1000).fadeOut();
                                        
                                       $.ajax({
                                            method: 'post',
                                            url: '/profile/getUpdate',
                                            dataType: 'json',
                                            data: { 
                                                 userId: userId,
                                            },
                                            success: function(data) {
                                                 var html = '';

                                                 html += '<div class="content"><div class="profileInfoUser">';
                                                 html += '<div class="profileInfoUserLeft">';
                                                 html += '<img src="http://animereviews.ru/uploads/users/'+ data.info.avatar +'" alt="">';
                                                 html += '</div>';
                                                 html += '<div class="profileInfoUserRight">';
                                                 html += '<div>Логин: <span><input type="text" value="'+ data.info.login +'" name="loginUser"></span></div>';
                                                 html += '<div>Обо мне: <span><input type="text" value="'+ data.info.about +'" name="aboutUser"></span></div>';
                                                 html += '<div>Вконтакте: <span><input type="text" value="'+ data.info.vk +'" name="vkUser"></span></div>';
                                                 html += '</div>';
                                                 html += '<button id="updateProfile">Обновить</button>';
                                                 html += '</div></div>';
                                                $('.otherInfo').append(html);
                                            }
                                       });
                                       $('.otherInfo').on('click', '#updateProfile', function() {
                                                     var loginUser = $.trim($(this).parent().parent().find('input[name="loginUser"]').val());
                                                     var aboutUser = $.trim($(this).parent().parent().find('input[name="aboutUser"]').val());
                                                     var vkUser = $.trim($(this).parent().parent().find('input[name="vkUser"]').val());

                                                      $.ajax({
                                                           method: 'post',
                                                           url: '/profile/update',
                                                           dataType: 'json',
                                                           data: {
                                                               loginUser: loginUser,
                                                               aboutUser: aboutUser,
                                                               vkUser: vkUser,
                                                           },
                                                           success: function (data) {
                                                                if ( data.error ) pushNotifications('.successJsButtonError', data.error);
                                                           } 
                                                      });
                                                                window.location.reload();
                                                });
                            });
                          $('input[type=file]').bind('click', function() {
                                   $(this).parent().find('label').remove();
                                   $(this).parent().find('.labelForChangeImg').append('<i class="fa fa-check" aria-hidden="true" id="avatarSend"></i>');
                                   $('#avatarSend').on('click', function(e) {
                                    e.preventDefault();

                                    var $input = $("#avatarUser");
                                    var fd = new FormData;

                                    fd.append('img', $('#avatarUser')[0].files[0]);

                                    var imgType = $('input[type=file]').val();

                                    switch(imgType.substring(imgType.lastIndexOf('.') + 1).toLowerCase()){
                                        case 'gif': case 'jpg': case 'png':
                                               $.ajax({
                                                  url: '/profile/updateAvatar',
                                                  data: fd,
                                                  processData: false,
                                                  contentType: false,
                                                  type: 'POST',
                                                  success: function(data){
                                                       window.location.reload();
                                                       if ( data.error ) pushNotifications('successJsButtonError', data.error);
                                                  }
                                            });
                                            break;
                                        default:
                                            $(this).find('i').remove();
                                            $(this).parent().html('<label for="avatarUser" class="labelForChangeImg1"><i class="fa fa-cloud" aria-hidden="true"></i></label>');
                                            pushNotifications('successJsButtonError', 'Это не изображение');
                                            break;
                                    }                                        
                                 });
                         });
                          function readURL(input) {
                            if ( input.files && input.files[0] ) {
                                var reader = new FileReader();

                                reader.onload = function (e) {
                                    $('.profileInfoUserLeft img').attr('src', e.target.result);
                                };
                                reader.readAsDataURL(input.files[0]);
                            }
                          }
                          $("#avatarUser").change(function(){
                                          readURL(this);
                          });
                     });
        </script>

        <style>
            .inputfile {
              width: 0.1px;
              height: 0.1px;
              opacity: 0;
              overflow: hidden;
              position: absolute;
              z-index: -1;
            }
            .inputfile:focus + label {
              outline: 1px dotted #000;
              outline: -webkit-focus-ring-color auto 5px;
            }
            .inputfile + label * {
              pointer-events: none;
            }
            .profileInfoUserLeft {
                position: relative;
            }
            .labelForChangeImg {
                padding: 5px 10px;
                border-radius: 4px;
                position: absolute;
                right: 35px;
                background: rgba(0,0,0,.4);
            }
            .labelForChangeImg i {
                font-size: 22px;
                color: rgba(250,250,250,1);
            }
            .labelForChangeImg i:hover {
                cursor: pointer;
                color: #f0f0f0;
            }
            #avatarSend {
                color: #fff;
                text-shadow: 4px 3px 6px rgba(0,0,0,.6);
            }
            #avatarSend:hover {
                cursor: pointer;
                text-shadow: none;
            }
            .labelForChangeImg2 {
            }
        </style>

@stop