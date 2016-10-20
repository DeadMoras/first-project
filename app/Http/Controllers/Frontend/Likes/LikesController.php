<?

namespace App\Http\Controllers\Frontend\Likes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LikesController extends Controller
{

	public function sendLike(Request $request)
	{
		$likes = new \App\Likes;

		$likeUser = $request->input('likesUserId');
		$likeReview = $request->input('likesReviewId');

		$likesUser = $likes->where('user_id', $likeUser)->where('review_id', $likeReview)->count();

		if ( $likesUser > 0 ) 
		{
			return response()->json(['error' => 'Вы уже оценивали эту рецензию']);
	             } else {
	             	$likes->user_id = $likeUser;
	             	$likes->review_id = $likeReview;

	             	$likes->save();

	             	$likesCountU = \App\Reviews::where('id', '=', $likeReview)
					->update(['countrait' => \DB::raw('countrait + 1')]);

			$likescount = $likes->where('review_id', $likeReview)->count();

			return response()->json(['success' => $likescount]);
		}
	}

}