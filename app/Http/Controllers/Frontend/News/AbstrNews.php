<?

namespace App\Http\Controllers\Frontend\News;
use DB;

class AbstrNews 
{
	public function returnNews($yeaBitch, $sort)
	{
		$allNews = DB::table('news')
			      ->leftJoin('users', 'users.id', '=', 'news.user_id')
			      ->select('news.*', 'users.avatar', 'users.login', 'users.id')
			      ->skip($yeaBitch)
		                   ->take(20);

                          if ( $sort == 'likes' ) {
                          	$sortByLikes = $allNews->orderBy('news.likes', 'desc')->get();
		             $data = $sortByLikes;
		             return response()->json(['news' => $data]);
                          } else if ( $sort == 'dislikes' ) {
                          	$sortByLikes = $allNews->orderBy('news.dislikes', 'desc')->get();
		             $data = $sortByLikes;
		             return response()->json(['news' => $data]);
                          } else {
                          	$sortByNew = $allNews->orderBy('news.created_at', 'desc');
                          	$data = $sortByNew;
                          	return response()->json(['news' => $data->get()]);
                          }
		                   // ->orderBy('news.created_at', 'desc')
			      // ->get();

	}

	public function loadComments($id)
	{
		$comments = DB::table('news_comments')
			           ->join('users', 'users.id', '=', 'news_comments.user_id')
			           ->where('news_comments.newss_id', '=', $id)
			           ->select('users.login', 'users.avatar', 'users.id', 'news_comments.*')
			           ->take(10)
			           ->orderBy('news_comments.created_at', 'desc')
			           ->get();

	             return response()->json(['comments' => $comments]);
	}

	public function sendLike($object)
	{		
		$userLike = DB::table('news_likes')
			       ->where('user_id', $object['likesUserId'])
			       ->where('new_id', $object['newsId'])
			       ->count();

	             if ( $userLike > 0 ) {
	             	return response()->json(['error' => 'Вы уже оценивали новость']);
	             } else {
	             	if ( $object['likeable'] == 'likeComment' )
	             	{
	             		$saveLike = DB::table('news_likes')
		             		        ->insert([
			             		        'new_id' => $object['newsId'],
			             		        'user_id' => $object['likesUserId'],
			             		        'likeDislike' => 0,
			             		        'likeable' => 'News'
		             		        ]);

             		             DB::table('news')
	             		       ->where('news_id', $object['newsId'])
	             		       ->update(['likes' => \DB::raw('likes + 1')]);

             		             if ( $saveLike != true ) return response()->json(['error' => 'Возникла ошибка']);
             		             else return response()->json(['success' => 'Вы успешно оценили новость']);
	             	} else {
	             		$saveDislike = DB::table('news_likes')
		             		        ->insert([
			             		        'new_id' => $object['newsId'],
			             		        'user_id' => $object['likesUserId'],
			             		        'likeDislike' => 1,
			             		        'likeable' => 'News'
		             		        ]);

	             		DB::table('news')
	             		       ->where('news_id', $object['newsId'])
	             		       ->update(['dislikes' => \DB::raw('dislikes + 1')]);        

             		             if ( $saveDislike != true ) return response()->json(['error' => 'Возникла ошибка']);
             		             else return response()->json(['success' => 'Вы успешно оценили новость']);
	             	}
	             }
	}

	public function getEach($id)
	{
		$each = DB::table('news')
			 ->join('users', 'users.id', '=', 'news.user_id')
			 ->select('news.*', 'users.avatar', 'users.login', 'users.id', 'users.created_at', 'users.vk')
			 ->where('news.news_id', $id)
			 ->first();

		return $each;
	}

	public function commentsEach($id, $skippComments)
	{
		$comments = DB::table('news_comments')
			           ->join('users', 'users.id', '=', 'news_comments.user_id')
			           ->join('news', 'news.news_id', '=', 'news_comments.newss_id')
			           ->where('news.news_id', '=', $id)
			           // ->where('news.likeable', '=', 'news_comments')
			           ->select('news_comments.*', 'users.avatar', 'users.login')
			           ->skip($skippComments)
			           ->take(20)
			           ->get();

	             return response()->json(['data' => $comments]);
	}

	public function saveComment($comm, $user, $new, $toUserId)
	{
		$getSave = DB::table('news_comments')
				 ->insert([
				 	'newss_id' => $new,
				 	'user_id' => $user,
				 	'comment_body' => $comm,
				 	'to_user_id' => $toUserId
				 ]);

		if ( $getSave == true ) {

			  $commentReturn = DB::table('news_comments')
				           ->join('users', 'users.id', '=', 'news_comments.user_id')
				           ->select('news_comments.*', 'users.avatar', 'users.login', 'users.id')
				           ->where('news_comments.user_id', $user)
				           ->orderBy('news_comments.news_comments_id', 'desc')
				           ->first();

		             return response()->json(['success' => $commentReturn]);

		} else {
			return response()->json(['error' => 'Возникла ошибка']);
		}
	}

	public function likeOnComment($likeableComment, $likeCommentId, $whoLiked)
	{
		$userLike = DB::table('news_likes')
			       ->where('user_id', $whoLiked)
			       ->where('comment_id', $likeCommentId)
			       ->count();

	            if ( $userLike > 0 ) {
		            	return response()->json(['error' => 'Вы уже оценивали комментарий']);
	            } else {
		            	if ( $likeableComment == 'eachNewsCommentsViewLikesLike' )
			{
				$getSaveLikeToComment = DB::table('news_likes')
								  ->insert([
								  	'comment_id' => $likeCommentId,
								  	'user_id' => $whoLiked,
								  	'likeDislike' => 0,
								  	'likeable' => 'news_comments_like'
								  ]);
				DB::table('news_comments')
	             		       ->where('news_comments_id', $likeCommentId)
	             		       ->update(['likes' => \DB::raw('likes + 1')]);

             		              if ( $getSaveLikeToComment != true ) return response()->json(['error' => 'Возникла ошибка']);
             		             else return response()->json(['success' => 'Вы успешно оценили комментарий']);
			} else {
				$getSaveLikeToComment = DB::table('news_likes')
								  ->insert([
								  	'comment_id' => $likeCommentId,
								  	'user_id' => $whoLiked,
								  	'likeDislike' => 1,
								  	'likeable' => 'news_comments_like'
								  ]);
				DB::table('news_comments')
	             		       ->where('news_comments_id', $likeCommentId)
	             		       ->update(['dislikes' => \DB::raw('dislikes + 1')]);

             		             if ( $getSaveLikeToComment != true ) return response()->json(['error' => 'Возникла ошибка']);
         		                          else return response()->json(['success' => 'Вы успешно дизлайкнули комментарий']);
			}
	            }
	}

}
