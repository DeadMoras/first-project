<?

namespace App\Http\Controllers\Frontend\Users;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cache;
use Image;
use DB;

class UserController extends Controller
{

	public function getProfile() 
	{
		$profile =  User::where('id', Auth::user()->id)->first();

		return view('user.profile', ['profile' => $profile]);
	}

	public function getUpdateProfile(Request $request)
	{
		$profileUpdateInfo = User::where('id', $request->input('userId'))->first();

		return response()->json(['info' => $profileUpdateInfo]);
	}

	public function postUpdateProfile(Request $request)
	{
		$update = User::where('id', Auth::user()->id)->first();

		$update->about = $request->input('aboutUser');
		$update->vk = $request->input('vkUser');
		$update->login = $request->input('loginUser');

		if ( $update->save() ) return response()->json(['error' => 'Возникла ошибка']);
	}

	public function updateImgUser(Request $request)
	{
		$update = User::where('id', Auth::user()->id)->first();

		if ($request->file('img'))
	    	{
	    		$image = $request->file('img');
	    		$filename = $update->email . '.' . $update->id . '.jpg';
	    		Image::make($image->getRealPath())->resize(340,300)->save(public_path('uploads/users/' . $filename));            
	    		
	     		$update->avatar = $filename;
		    	if ( !$update->save() ) return response()->json(['error' => 'Возникла ошибка']);
		    	else return response()->json($filename);
	    	}

	}

	public function getUserProfile($id)
	{
		$profileUser = User::where('id', $id)->first();

		$commentsUser = DB::table('comments')
				     ->join('reviews', 'reviews.id', '=', 'comments.review_id')
				     ->where('comments.user_id', $id)
				     ->select('reviews.id', 'reviews.img_review', 'comments.body')
				     ->orderBy('comments.created_at', 'desc')
				     ->get();

		if ( Auth::check() ) {
			$subscribe = \App\Subscribe::select('*')
						          ->where('subscribe.from_user_id', Auth::user()->id)
						          ->where('subscribe.user_id', $id)
						          ->get()
						          ->toArray();	
			return view('user.userProfile', ['profile' => $profileUser, 'subscribe' => $subscribe, 'commentsUser' => $commentsUser]);
		} else {
			return view('user.userProfile', ['profile' => $profileUser, 'commentsUser' => $commentsUser]);
		}

	}

}