<?

namespace App\Http\Controllers\Frontend\Comments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Events\CommReply;

class CommentsReviewController extends Controller
{

	public function getComments($id, Request $request)
	{
		$comments = DB::table('comments')
			           ->join('users', 'users.id', '=', 'comments.user_id')
			           ->join('reviews', 'comments.review_id', '=', 'reviews.id')
			           ->where('reviews.id', '=', $id)
			           ->select('comments.*', 'users.avatar', 'users.login')
			           ->orderBy('comments.comment_id', 'desc')
			           ->skip($request->input('skip'))
			           ->take(20)
			           ->get();

	             return response()->json(['comments' => $comments]);
	}

	public function postAddComment(Request $request)
	{
		$save = \App\Comments::create([
		       	'body' => $request->input('commentBody'),
		       	'review_id' => $request->input('postId'),
		       	'user_id' => $request->input('userId'),
		       	'to_user_id' => $request->input('userReply'),
		       	'to_comment_id' => $request->input('commentId')
		       ]);

                          $commentReturn = DB::table('comments')
				           ->join('users', 'users.id', '=', 'comments.user_id')
				           ->select('comments.*', 'users.avatar', 'users.login', 'users.id')
				           ->where('comments.user_id', $request->input('userId'))
				           ->orderBy('comments.comment_id', 'desc')
				           ->first();

	             if ( $request->input('userReply') ) {
	             	event(new CommReply($save));
	             }

	             return response()->json(['returnComment' => $commentReturn]);
	}

	public function deleteComment(Request $request)
	{
		$deleteComment = DB::table('comments')
				             ->where('comments.comment_id', '=', $request->input('deleteCommentId'))
				             ->delete();

	             if ( !$deleteComment ) return response()->json(['error' => 'Возникла ошибка']);
	             else return response()->json(['success' => 'Комментарий был удален']);
	}

}