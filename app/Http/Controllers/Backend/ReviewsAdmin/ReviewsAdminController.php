<?

namespace App\Http\Controllers\Backend\ReviewsAdmin;

use App\Http\Controllers\Controller;
use \App\Events\NewReview;
use Illuminate\Http\Request;


class ReviewsAdminController extends Controller
{

	public function getIndex()
	{
		$reviews = \App\Reviews::paginate(20);

		return view('admin.reviews', [
			'reviews' => $reviews
		]);
	}

	public function deleteReview(Request $request)
	{
		$idReview = $request->input('reviewId');

		$delete = \App\Reviews::where('id', $idReview)->delete();

		if ( $delete == true ) return response()->json(['success' => 'aga']);
		else return response()->json(['error' => 'Возникла ошибка']);
	}

	public function getEdit($id)
	{
		$review = \App\Reviews::where('id', $id)->first();

		$categories = \App\Categories::all();

		$cats = [];
	           
	             foreach ($categories as $category) {
	                 $cats[$category->id] = $category->name;
	             }

		return view('admin.reviewsEdit', [
			'review' => $review,
			'cats' => $cats
		]);
	}

	public function postEdit($id, Request $request)
	{
		$review = \App\Reviews::find($id);

		$review->title = $request->input('title');
		$review->slowtitle = $request->input('slowtitle');
		$review->about = $request->input('about');
		$review->forindex = $request->input('forindex');
		$review->bodyindex = $request->input('bodyindex');
		$review->cat_id = $request->input('cats');

		if ( $request->input('userAuthor') )
		{
			$review->user_id = $request->input('userAuthor');
		}
		if ( $request->input('slowtitle') )
		{
			$review->slowtitle = $request->input('slowtitle');
		}

		if ($request->file('img_review'))
	    	{
	    		$image = $request->file('img_review');
	    		$filename = time() . '.' . $image->getClientOriginalName();
	    		\Image::make($image->getRealPath())->resize(1366,700)->save(public_path('uploads/reviews/' . $filename));            
	     	            
	     	            $review->img_review = $filename;
	    	}

     		$review->update();

     		return redirect()->route('adminReviews');
	}

	public function getAdd()
	{
		$categories = \App\Categories::all();

		$cats = [];
	           
	             foreach ($categories as $category) {
	                 $cats[$category->id] = $category->name;
	             }

		return view('admin.reviewsAdd', [
			'cats' => $cats
		]);
	}

	public function postAdd(Request $request)
	{

    		$image = $request->file('img_review');

    		$filename = time() . '.' . $image->getClientOriginalName();
    		\Image::make($image->getRealPath())->resize(1366,700)->save(public_path('uploads/reviews/' . $filename));            
     	            

     	            $saved = \App\Reviews::create([
				'title' => $request->input('title'),
				'slowtitle' => $request->input('slowtitle'),
				'about' => $request->input('about'),
				'forindex' => $request->input('forindex'),
				'bodyindex' => $request->input('bodyindex'),
				'cat_id' => $request->input('cats'),
				'user_id' => $request->input('userAuthor'),
		     	            'img_review' => $filename
			]);

     	            event(new NewReview($saved));

     		return redirect()->route('adminReviews');
	}

}