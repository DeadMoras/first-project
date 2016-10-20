<?

namespace App\Http\Controllers\Frontend\Subscribe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\SubNotify;
use App\Subscribe;

class SubscribeController extends Controller
{

	public function subscribe(Request $request)
	{
		$authUser = $request->input('authUserId');
		$thisUser = $request->input('thisUserId');

		//event
		$subscribe =  Subscribe::create([
					'user_id' => $thisUser,
					'from_user_id' => $authUser
			             ]);

		event(new SubNotify($subscribe));

		if ( $subscribe == true ) return response()->json(['success' => 'Вы успешно подписались']);
		else return response()->json(['error' => 'Возникла ошибка']);
	}

	public function subscribed(Request $request)
	{
		$authUser = $request->input('authUserId');
		$thisUser = $request->input('thisUserId');

		$subscribed = Subscribe::where('user_id', $thisUser)
			         ->where('from_user_id', $authUser)
			         ->delete();

		if ( $subscribed ) {
			return response()->json(['success' => 'Вы успешно отписались']);
		} else {
			return response()->json(['error' => 'Произошла ошибка']);
		}
	}

}