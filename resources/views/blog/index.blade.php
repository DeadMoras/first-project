@extends('main')

@section('title', 'Рецензии к аниме, аниме рецензии, лучшие рецензии для любого аниме.')

@section('metaContent', 'Чтение рецензий к аниме, манге. Аниме рецензии, бесплатно чтение рецензий к аниме. критика аниме')

@section('metaKey', 'Рецензия, рецензии к аниме, читать, аниме рецензии')

@section('metaImg', 'http://animereviews.ru/logo.png')

@section('content')

      <div class="contentIconsView">
            <a href="#" onclick="review.changeIcon(1)"><i class="fa fa-bars" aria-hidden="true"></i></a>
            <a href="#" onclick="review.changeIcon(0)"><i class="fa fa-clone" aria-hidden="true"></i></a>
        </div>
        <div class="content">
             @foreach ( $reviews as $r )
                 <div class="contentEachReview">
                    <div class="contentEachReviewTopInfo">
                        <span>{{ $r->title }}</span>
                        <span class="contentEachReviewTopInfoDate"><? echo App\Http\Controllers\TimerRu::create($r->created_at)->longDate();?></span>
                    </div>
                    <div class="contentEachReviewImg">
                        <img src="{{ asset('/uploads/reviews/'.$r->img_review) }}" alt="">
                    </div>
                    <p>
                       {{ $r->forindex }}
                    </p>
                    <div class="contentEachReviewBottomInfo">
                        <span class="contentEachReviewBottomInfoAuthor">
                            <i class="fa fa-user" aria-hidden="true"></i><a href="{{ route('userProfile', $r->user->id) }}">{{ $r->user->login }}</a>
                        </span>
                        <span class="contentEachReviewBottomInfoCats">
                            <i class="fa fa-tag" aria-hidden="true"></i><a>{{ $r->category->name }}</a>
                        </span>
                        <span class="contentReviewTopInfoBottomInfoLike" data-id="{{$r->id}}">
                          @if ( $r->countrait > 0 )
                            <i class="fa fa-heart-o" aria-hidden="true" style="color: #b07171"></i><a>{{ $r->countrait }}</a>
                            @else
                               <i class="fa fa-heart-o" aria-hidden="true"></i><a>{{ $r->countrait }}</a>
                            @endif
                        </span>
                        <a href="{{ route('eachReview', $r->slowtitle) }}" class="contentEachReviewBottomInfoRightArrow"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
                    </div>
                 </div>
                 @endforeach
            </div>

             <script>
                 var skipReviews = 10,
                 offsetNews = 0,
                 lengthReviews = $('.content .contentEachReview').length;

                 function moreReviews() {
                if ( lengthReviews >= 10 ) {
                      $.ajax({
                            method: 'get',
                            url: '/moreReviews',
                            data: {
                                  skipReviews: skipReviews
                            },
                            dataType: 'json',
                            success: function(data) {
                                  offsetNews++;
                                  skipReviews = offsetNews * 20;

                                  $.each(data.more, function() {
                                        var more = '';

                                         if ( localStorage.getItem('review.changeIcon') == 0 ) {
                                            more += '<div class="contentEachReview small">';
                                         } else {
                                            more += '<div class="contentEachReview">';
                                         }
                                        more += '<div class="contentEachReviewTopInfo">';
                                        more += '<span>'+ this.title +'</span>';
                                        more += '<span class="contentEachReviewTopInfoDate">'+ this.created_at +'</span>';
                                        more += '</div>';
                                        more += ' <div class="contentEachReviewImg"><img src="/uploads/reviews/'+ this.img_review +'" alt=""></div>';
                                        more += '<p>'+ this.forindex +'</p>';
                                        more += '<div class="contentEachReviewBottomInfo">';
                                        more += '<span class="contentEachReviewBottomInfoAuthor">';
                                        more += '<i class="fa fa-user" aria-hidden="true"></i><a href="/user/id'+ this.user_id +'">'+ this.login +'</a>';
                                        more += '</span>';
                                        more += '<span class="contentEachReviewBottomInfoCats">';
                                        more += '<i class="fa fa-tag" aria-hidden="true"></i><a>'+ this.name +'</a>';
                                        more += '</span>';
                                        more += '<span class="contentReviewTopInfoBottomInfoLike" data-id="'+ this.id +'">';
                                 if ( this.countrait > 0 ) {
                                        more += '<i class="fa fa-heart-o" aria-hidden="true" style="color: #b07171"></i><a>'+ this.countrait +'</a>';
                                 } else {
                                        more += '<i class="fa fa-heart-o" aria-hidden="true"></i><a>'+ this.countrait +'</a>';
                                 }
                                        more += '</span>';
                                        more += '<a href="/review/'+ this.id +'" class="contentEachReviewBottomInfoRightArrow"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>';
                                        more += '</div>';
                                        more += '</div>';

                                        $('.content').append(more);
                                  });
                            }
                      });
                 };
             };

            $(window).scroll(function() 
            {
              if  ($(window).scrollTop() == $(document).height() - $(window).height()) 
              {
                setTimeout(moreReviews(), 1000);
              }
            });
            
            </script>

@stop