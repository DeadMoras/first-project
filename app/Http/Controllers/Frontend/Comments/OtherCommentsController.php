<?

namespace App\Http\Controllers\Frontend\Comments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class OtherCommentsController extends Controller
{

	public function modalComment(Request $request)
	{
		$commentId = $request->input('commentId');

		$comment = DB::table('comments')
			         ->join('users', 'users.id', '=', 'comments.user_id')
			         ->where('comments.comment_id', $commentId)
			         ->select('users.login', 'users.avatar', 'users.id', 'comments.review_id', 'comments.body', 'comments.to_comment_id')
			         ->first();

	             return response()->json(['comment' => $comment]);
	}

	public function yourModalComment(Request $request)
	{
		$toCommentId = $request->input('to_comment_id');

		$data = DB::table('comments')
			        ->where('comments.comment_id', '=', $toCommentId)
			        ->select('body')
			        ->first();

	             return response()->json(['data' => $data]);
	}

}