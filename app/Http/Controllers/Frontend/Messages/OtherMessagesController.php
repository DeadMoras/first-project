<?

namespace App\Http\Controllers\Frontend\Messages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class OtherMessagesController extends Controller
{

	public function messageSend(Request $request)
	{
		$authUserId = $request->input('authUserId');
		$thisUserId = $request->input('thisUserId');
		$message = $request->input('messageFromProfileTextarea');

		$save = DB::table('messages')
		              ->insert([
		              	'from_user' => $authUserId,
		              	'to_user' => $thisUserId,
		              	'message' => $message
		              ]);

	             if ( $save == true ) return response()->json(['success' => 'Сообщение успешно отправлено']);
	             else return response()->json(['error' => 'Возникла ошибка']);
	}

	public function messageArchive(Request $request)
	{
		$allMessages = DB::table('messages')
				->join('users', 'users.id', '=', 'messages.from_user')
				->where('to_user', '=', $request->input('thisUserId'))
				->orWhere('from_user', '=', Auth::user()->id)
				->where('from_user', '=', $request->input('thisUserId'))
				->orWhere('to_user', '=', Auth::user()->id)
				->where('to_user', '=', $request->input('thisUserId'))
				->orWhere('from_user', '=', $request->input('thisUserId'))
				->select('messages.*', 'users.login', 'users.avatar')
				->orderBy('messages.created_at', 'desc')
				->get();

	             return response()->json(['header_messages' => $allMessages]);
	}

	public function getCountMessages()
	{
		$count = DB::table('messages')
			         ->where('messages.to_user', '=', Auth::user()->id)
			         ->where('messages.readed', '=', 1)
			         ->count();

	            return response()->json(['count' => $count]);
	}

}