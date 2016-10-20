<?

namespace App\Http\Controllers\Backend\Comments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CommentsController extends Controller
{

	public function getIndex()
	{

		$allComments = DB::table('comments')
				  ->join('users', 'users.id', '=', 'comments.user_id')
				  ->select('users.login', 'users.id', 'users.avatar', 'comments.comment_id', 'comments.body', 'comments.review_id')
				  ->paginate(20);

		return view('admin.comments', [
				'allComments' => $allComments,
			]);
	}

	public function deleteComment(Request $request)
	{
		$commentId = $request->input('commentId');

		$commentDeleted = DB::table('comments')
				        ->where('comment_id', $commentId)
				        ->delete();

	             if ( $commentDeleted == true ) return response()->json(['success' => 'ok']);
	             else return response()->json(['error' => 'aga']);
	}

	public function editComment(Request $request)
	{
		$returnComment = DB::table('comments')
				      ->where('comment_id', $request->input('commentId'))
				      ->select('body')
				      ->first();

	             return response()->json(['comment' => $returnComment]);
	}

	public function saveNewComment(Request $request)
	{
		$newCommentSave = DB::table('comments')
					      ->where('comment_id', $request->input('commentId'))
					      ->update([
					      	'body' => $request->input('newMessage')
					      ]);

	             if ( $newCommentSave == true ) return response()->json(['success' => 'aga']);
	             else return response()->json(['error' => 'все плохо']);
	}

}