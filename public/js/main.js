$(document).ready(function() {
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      var reviewView = $('.contentEachReview');

      review = {
          changeIcon: function (type) {
               if ( type == 1 ) {
                   localStorage.removeItem('review.changeIcon');
                   reviewView.removeClass('small');
               } else {
                   localStorage.setItem('review.changeIcon', 0);
                   reviewView.addClass('small');
               }
          },
      }
      if ( localStorage.getItem('review.changeIcon') == 0 ) review.changeIcon(0);

});

function pushNotifications (classDiv, text) {
       var pushNoti = {
           classDiv: '',
           text: '',
       };
         pushNoti.classDiv = classDiv;
         pushNoti.text = text;

         var $OuterDiv = $('<div id="successJsButton"></div>')
              .appendTo($('header'))
              .addClass(pushNoti.classDiv)
              .html(pushNoti.text)
              .fadeIn(1200).fadeOut();

};
 function replyTo(comment_id, user_id, user_name) {
                    $('.viewComments ul').find('.viewCommentsIcons').fadeOut();
                    $('.sendCommentSmiles').append('<li data-id="' + comment_id +
                        '"><span data-id="'+ user_id +'"></span></li>');
                    $('.sendComment textarea[name="commentSendReview"]') 
                        .val('#' + user_name + ', ' + $('.sendComment textarea[name="commentSendReview"]') 
                        .val()).focus();
};
