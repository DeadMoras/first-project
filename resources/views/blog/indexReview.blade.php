@extends('main')

@section('title', $reviewEach->title)

@section('metaContent', $reviewEach->forindex)

@section('metaKey', "Рецензия к аниме $reviewEach->title, рецензии, аниме рецензия $reviewEach->title, $reviewEach->title")

@section('metaImg', "http://animereviews.ru/uploads/reviews/$reviewEach->img_review")

@section('content')

     <div class="content">
         <div class="reviewFull">
     	 <div class="contentReviewTopInfo">
     		<span>{{ $reviewEach->title }}</span>
     		<span class="contentReviewTopInfoDate"><? echo App\Http\Controllers\TimerRu::create($reviewEach->created_at)->longDate();?></span>
     	</div>
     	<div class="contentReviewTopInfoImg">
	     	<img src="{{ asset('/uploads/reviews/'.$reviewEach->img_review) }}" alt="">
     	</div>
     	<div class="contentReviewTopInfoAboutReview">
                         {!! $reviewEach->about !!}
     	</div>
     	    <div class="contentReviewTopInfoSubscribe">
             	<button>Об авторе</button>
     	    <div class="contentReviewTopInfoInfoAboutAuthor">
     	    	   <img src="{{ asset('/uploads/users/'.$reviewEach->user->avatar) }}" alt="">
     	    	   <a href="{{ route('userProfile', $reviewEach->user->id) }}">{{ $reviewEach->user->login }}</a>
     	    	   <hr>
     	    	   <div>{{ $reviewEach->user->about }}</div>
     	    </div>
     	</div>
     	<div class="contentReviewTopInfoBody">
     	    <p>
     		{!! $reviewEach->bodyindex !!}
                 </p>   
        </div>
     	<div class="contentReviewTopInfoBottomInfo">
     		<span class="contentReviewTopInfoBottomInfoComments">
                            <i class="fa fa-comment" aria-hidden="true"></i>
                        </span>
                        <span class="contentReviewTopInfoBottomInfoCats">
                            <i class="fa fa-tag" aria-hidden="true"></i><a href="#">{{ $reviewEach->category->name }}</a>
                        </span>
                        <span class="contentReviewTopInfoBottomInfoLike" data-id="{{$reviewEach->id}}">
                          @if ( $reviewEach->countrait > 0 )
                             <i class="fa fa-heart-o" aria-hidden="true" style="color: #b07171"></i>{{ $reviewEach->countrait }}
                          @else
                            <i class="fa fa-heart-o" aria-hidden="true"></i>{{ $reviewEach->countrait }}
                          @endif
                        </span>
     	</div>
         </div>

     </div>
         <div class="comments">
         	@include('comments.main')
         </div>

@stop