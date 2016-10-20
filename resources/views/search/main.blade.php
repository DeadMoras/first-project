@extends('main')

@section('title', 'Поиск')

@section('metaContent', 'Поиск. Поиск по вашему запросу.')

@section('metaImg', 'http://animereviews.ru/logo.png')

@section('content')

     <div class="content">
       @if ( count($data) == 0 ) 
         Ничего нету
       @else
             @foreach ( $data as $r )
               
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
           @endif
            </div>

@stop