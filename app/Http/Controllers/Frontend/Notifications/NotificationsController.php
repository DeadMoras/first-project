<?

namespace App\Http\Controllers\Frontend\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications;
use Illuminate\Support\Facades\Auth;
use DB;

class NotificationsController extends Controller
{

	public function getNotifications()
	{
		if ( Auth::check() ) {
			
			$data = Notifications::where('user_id', Auth::user()->id)->where('readed', 1)->take(5)->get();

			return response()->json(['notify' => $data]);
		}
	}

	public function getPageNotify()
	{
		if ( Auth::check() ) {

			$data = Notifications::where('user_id', Auth::user()->id)->get();

			$not = DB::table('subscribe')
				     ->join('users', 'users.id', '=', 'subscribe.user_id')
				     ->where('subscribe.from_user_id', '=', Auth::user()->id)
				     ->select('users.id', 'users.avatar', 'users.login')
				     ->get();

			return view('user.notifications', [
					'data' => $data,
					'not' => $not
				]);
		}
	}

	public function getReaded(Request $request)
	{
		$idNotify = $request->input('notifyId');

		$update = Notifications::where('id', $idNotify)
					 ->update(['readed' => 0]);

		if ( $update == true ) return response()->json(['success' => 'aga']);
		else return response()->json(['error' => 'ne aga']);
	}

	public function getDeleteNotify(Request $request)
	{
		$notId = $request->input('notId');

		$delete = Notifications::where('id', $notId)
				            ->delete();

	             if ( $delete == true ) return response()->json(['success' => 'aga']);
	             else return response()->json(['error' => 'ne aga']);
	}

}