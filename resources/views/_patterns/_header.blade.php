<header>
     @if ( Auth::check() )
              <div class="rightProfileHidden">
                <div class="rightProfileHiddenClose"></div>
             <div class="rightProfileHiddenPanel">
                  <img src="{{ asset('/uploads/users/'.Auth::user()->avatar) }}" alt="">
                  <ul>
                    <li><a href="/">Главная страница</a></li>
                    <li><a href="/profile">Мой профиль</a></li>
                    <li><a href="/profile/notifications">Уведомления</a></li>
                    <li><a href="{{ route('logoutUser') }}">Выход</a></li>
                  </ul>
             </div>
            </div>
        @endif
        <div class="headerFirstMenuPanel">
             <div class="headerFirstMenuPanelLogo"></div>
               @if ( Auth::check() )
                 <div class="headerFirstMenuPanelProfileMini">
                    <img src="{{ asset('/uploads/users/'.Auth::user()->avatar) }}" alt="">
                    <span>#{{ Auth::user()->login }}</span>
                 </div>
               @else
                 <div class="headerFirstMenuPanelRightButtons">
                      <i class="fa-key fa fa-sign-in" aria-hidden="true"></i>
                      <a href="/register"><i class="fa fa-share" aria-hidden="true"></i></a>
                 </div>
               @endif
        </div>
        <div class="headerSecondMenu">
            <ul>
                <li><a href="/">Главная страница</a></li>
                <li><a href="/news">Форум</a></li>
                @if ( !Auth::check() )
                <li><a href="/register">Регистрация</a></li>
                @else
                <li><a href="{{ route('logoutUser') }}">Выход</a></li>
                @endif
              @if ( Auth::check() )
            </ul>
            <div class="headerRigthIcons">
                     <div class="notificationsIconHeader">
                <i class="fa fa-bell-o" aria-hidden="true"></i>
                <span></span>
                     </div>
                     <div class="messagesIconHeader">
                <a href="/messages"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                <span></span>
                     </div>
            </div>
              @endif
        </div>
    </header>
    @if ( Auth::check() )
      <script>
      $(document).ready(function() {

          $('.headerFirstMenuPanelProfileMini').click(function() {
          $('.rightProfileHidden').css('display', 'block').animate({
              opacity: 1,
              right: 0,
          },300);
          $('.rightProfileHiddenPanel').css('display', 'block').animate({
              width: '22%',
              height: '100%',
              right: 0
          }, 300);
      });
      $('.rightProfileHiddenClose').click(function() {
              $('.rightProfileHiddenPanel').css('display', 'none');
              $('.rightProfileHidden').css('display', 'none');
      });
      $('.notificationsIconHeader').click(function() {
          $(this).toggleClass('notificationsIconHeaderActive');
          $('.notificationsIconHeaderContent').toggleClass('notificationsIconHeaderContentActive').animate({
                opacity: 1,
                bottom: '10px',
                right: '20px'
            }, 500);
          });

      $.ajax({
          method: 'get',
          url: '/count_messages',
          dataType: 'json',
          success: function(data) {
               $('.messagesIconHeader span').append(data.count);
          }
      });
         $.ajax({
             method: 'get',
             url: '/notifications',
             dataType: 'json',
             success: function(data) {
                 $('.notificationsIconHeader span').append(data.notify.length);
                 $.each(data.notify, function() {
                      var not = '';
                      not += '<li>';
                      not += this.title;
                      not += '</li.';

                      $('.notificationsIconHeaderContent ul').append(not);
                 });
             }
         });
    });
      </script>
    @else
       <script>
           $('.fa-key').click(function() {
          $('.modalHeaderAuthMain').css('display', 'block').animate({
            opacity: 1,
            // right: 0
          }, 300);
          $('.modalHeaderAuth').animate({
            height: '350px',
            left: '400px'
          }, 500);
          $('.modalHeaderAuthTitle').find('i').click(function() {
            $(this).parent().parent().animate({
              height: 0,
              left: '100px'
            }, 500);
            $(this).parent().parent().parent().animate({},1000).fadeOut();
          });
        });
       </script>
    @endif
    <div class="modalCommentsFromNotifyMain">
      <div class="modalCommentsFromNotify">
        <div class="modalCommentsFromNotifyMainTitle">
           <div>
           
           </div>
             <i class="closeNot fa fa-times" aria-hidden="true"></i>
       </div>
       <div class="modalCommentsFromNotifyCommentAll">
       <div class="modalCommentsFromNotifyComment">
           
       </div>
       </div>
       <div class="modalCommentsFromNotifyYourComment">
          Ваш комментарий
          <span></span>
       </div>
        <div class="modalCommentsFromNotifyBottom">
           
        </div>
      </div>
</div>