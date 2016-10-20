<?

namespace App\Http\Controllers\Frontend\Reviews;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Reviews;

class ReviewsController extends Controller
{

	public function getIndex()
	{
		$reviews = Reviews::orderBy('created_at', 'desc')
				         ->take(10)
				         ->get();

		return view('blog.index', ['reviews' => $reviews]);
	}

	public function moreScrollReviews(Request $request)
	{
		$moreReviews = \DB::table('reviews')
				   ->join('categories', 'categories.id', '=', 'reviews.cat_id')
				   ->join('users', 'users.id', '=', 'reviews.user_id')
				   ->select('reviews.*', 'users.login', 'categories.name')
				   ->skip($request->input('skipReviews'))
				   ->take(10)
				   ->orderBy('reviews.created_at', 'desc')
				   ->get();

		return response()->json(['more' => $moreReviews]);
	}

	public function getEachReview($slowtitle)
	{
		$reviewEach = Reviews::where('slowtitle', $slowtitle)->first();

		return view('blog.indexReview', ['reviewEach' => $reviewEach]);
	}

}