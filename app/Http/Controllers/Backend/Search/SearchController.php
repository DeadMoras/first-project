<?

namespace App\Http\Controllers\Backend\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SearchController extends Controller
{

	public function getUsers(Request $request)
	{
		$text = $request->get('searchText');

		$data = \App\User::where('id', 'LIKE', '%' . $text . '%')
				     ->orWhere('login', 'LIKE', '%' . $text . '%')
				     ->get();

	             return response()->json(['search' => $data]);
	}

	public function getComments(Request $request)
	{
		$text = $request->get('searchText');

		$data = DB::table('comments')
			->join('users', 'users.id', '=', 'comments.user_id')
			->where('comment_id', 'like', '%' .$text. '%')
			->orWhere('review_id', 'like', '%' .$text. '%')
			->orWhere('body', 'like', '%' .$text. '%')
			->select('users.login', 'users.id', 'users.avatar', 'comments.comment_id', 'comments.body', 'comments.review_id')
			->get();

	             return response()->json(['search' => $data]);
	}

	public function getReviews(Request $request)
	{
		$text = $request->get('searchText');

		$data = DB::table('reviews')
			->where('review_id', 'like', '%' .$text. '%')
			->orWhere('title', 'like', '%' .$text. '%')
			->select('reviews.*')
			->get();

		return response()->json(['search' => $data]);
	}

}