@if ( Auth::check() )
  <div class="sendComment">
         	        <div class="sendCommentSmiles">
                        {{-- <span id="sendCommentB">b</span> --}}
         	           {{-- <span id="sendCommentI">i</span> --}}
                  </div>
            <textarea name="commentSendReview" id="commentSendReview" placeholder="Ваш комментарий..."></textarea>
            <button>Отправить</button>
          </div>
@endif
          <div class="viewComments">
            <ul>
                          <div class="n0Comments"></div>
            </ul>
          </div>
         <script>

                var userId = '@if(Auth::check()){{Auth::user()->id}}@endif';
                var postId = '{{ $reviewEach->id }}';
                var skip, offset = 0;

                function getComments() {
                     $.ajax({
                          method: 'get',
                          url: '/review/' + postId + '/comments',
                          dataType: 'json',
                          data: { skip: skip },
                          beforeSend: function () {
                            $('.more-comments').remove();
                          },
                          success: function(data) {
                            offset++;
                            skip = offset * 20;
                           $('.contentReviewTopInfoBottomInfoComments').append(data.comments.length)
                              if (data.comments.length >= 20) {
                                $('.viewComments').append('<div class="more-comments" onclick="getComments()">Еще комментарии</div>');
                            }
                                   $.each(data.comments, function() {
                                       var comment = '';

                                       comment += '<li data-id="'+ this.comment_id +'"';
                                       if ( userId == this.user_id ) {
                                          comment += 'class="my-comment"';
                                          comment += '>';
                                          comment += '<div class="viewCommentsIcons">';
                                          comment += '<span><i class="fa fa-trash-o" aria-hidden="true" id="deleteComment"></i></span>';
                                          comment += '</div>';
                                      } else {
                                       comment += '>';
                                      }
                                  if ( userId ) {
                                      if ( userId != this.user_id ) {
                                           comment += '<div class="viewCommentsIcons">';
                                           comment += '<span onclick="replyTo(' + this.comment_id + ',  '+ this.user_id +', \'' + this.login.replace('\'', '\\\'') + '\')"><i class="fa fa-bullhorn" aria-hidden="true"></i></span>';
                                           comment += '</div>';
                                      }
                                  }
                                       comment += '<div class="viewCommentsImg"><img src="/uploads/users/'+ this.avatar +'" alt=""></div>';
                                       comment += '<span class="viewCommentsLogin"><a href="/user/id'+ this.user_id +'">'+ this.login +'</a></span>';
                                       comment += '<div class="viewCommentsDate">'+ this.created_at +'</div>';
                                       comment += '<div class="viewCommentsComment">'+ this.body +'</div>';
                                       comment += '</li>';

                                       $('.viewComments ul').append(comment);
                                   });
                          }
                     });
                };


               $('.sendComment').find('button').click(function() {
                   var that = $(this);
                   var reply_to = that.parent().find('.sendCommentSmiles');
                   var commentId = '';
                   if ( reply_to.length > 0) {
                       commentId = reply_to.find('li').data('id');
                       userReply = reply_to.find('li').find('span').data('id');
                   }

                   var commentBody = $.trim(that.parent().find('#commentSendReview').val());

                   if ( commentBody.length > 0) {
                        $.ajax({
                         method: 'post',
                         url: '/review/'+ postId +'/comments',
                         dataType: 'json',
                         data: {
                            commentBody: commentBody,
                            postId: postId,
                            userId: userId,
                            commentId: commentId,
                            userReply: userReply
                         },
                         success: function(data) {
                              var returnComment = '';
                             returnComment += '<li data-id="'+ data.returnComment.comment_id +'"';
                             if ( userId == data.returnComment.user_id ) {
                                returnComment += 'class="my-comment"';
                                returnComment += '>';
                                returnComment += '<div class="viewCommentsIcons">';
                                returnComment += '<span><i class="fa fa-trash-o" aria-hidden="true" id="deleteComment"></i></span>';
                                returnComment += '</div>';
                            } else {
                             returnComment += '>';
                            }
                             returnComment += '<div class="viewCommentsImg"><img src="/uploads/users/'+ data.returnComment.avatar +'" alt=""></div>';
                             returnComment += '<span class="viewCommentsLogin"><a href="user/id'+ data.returnComment.user_id +'">'+ data.returnComment.login +'</a></span>';
                             returnComment += '<div class="viewCommentsDate">'+ data.returnComment.created_at +'</div>';
                             returnComment += '<div class="viewCommentsComment">'+ data.returnComment.body +'</div>';
                             returnComment += '</li>';

                             $('.viewComments ul').prepend(returnComment);
                             $('#commentSendReview').val('');
                             $('.viewComments ul').find('.viewCommentsIcons').fadeIn();
                         }
                     });
                   } else {
                       pushNotifications('successJsButtonError', 'Введите комментарий');
                   }
               });

               function deleteComment() {
                   $('.viewComments ul').on('click', '#deleteComment', function() {
                        var that = $(this);
                        var deleteCommentId = that.parent().parent().parent().data('id');

                        $.ajax({
                            method: 'post',
                            url: '/delete_comment',
                            dataType: 'json',
                            data: {
                                deleteCommentId: deleteCommentId,
                            },
                            success: function(data) {
                                if ( data.error ) { 
                                   pushNotifications('successJsButtonError', data.error);
                                } else {
                                    that.parent().parent().parent().animate({
                                        bottom: '400px',
                                        left: '700px'
                                    }, 500).fadeOut();
                                }
                            }
                        });
                   });
               };

               $(document).ready(function() {
                   deleteComment();
                   getComments();
              }); 
         </script>