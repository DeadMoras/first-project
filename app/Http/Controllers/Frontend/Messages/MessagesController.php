<?

namespace App\Http\Controllers\Frontend\Messages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class MessagesController extends Controller
{

	public function messagesIndex()
	{
		$messages = DB::table('messages')
			           ->join('users', 'users.id', '=', 'messages.from_user')
			           ->where('messages.to_user', '=', Auth::user()->id)
			           ->select('messages.*', 'users.id', 'users.login', 'users.avatar')
			           ->take(20)
			           ->orderBy('messages.created_at', 'desc')
			           ->get();

	             return view('messages.index', ['messages' => $messages]);
	}

	public function moreMessages(Request $request)
	{
		$moreM = DB::table('messages')
			           ->join('users', 'users.id', '=', 'messages.from_user')
			           ->where('messages.to_user', '=', Auth::user()->id)
			           ->select('messages.*', 'users.id', 'users.login', 'users.avatar')
			           ->skip($request->input('skipM'))
			           ->take(20)
			           ->orderBy('messages.created_at', 'desc')
			           ->get();

	            return response()->json(['more' => $moreM]);
	}

	public function getEachMessage($id)
	{
		$each = DB::table('messages')
			->join('users', 'users.id', '=', 'messages.from_user')
		              ->where('message_id', '=', $id)
		              ->select('messages.*', 'users.id', 'users.login', 'users.avatar')
		              ->first();

	             return view('messages.eachMessage', ['each' => $each]);
	}

	public function messageDelete(Request $request)
	{
		$messageId = $request->input('messageId');

		$messageDelete = DB::table('messages')
				      ->where('messages.message_id', '=', $messageId)
				      ->delete();

	             if ( $messageDelete == true ) {
	             	return response()->json(['success' => 'Сообщение удалено']);
	             } else {
	             	return response()->json(['error' => 'Возникла ошибка']);
	             }
	}

	public function messageSend(Request $request)
	{
		$this->validate($request, [
			'sendMessageFromMessage' => 'required'
		]);

		$sendM = DB::table('messages')
			    ->insert([
			    	'message' => $request->input('sendMessageFromMessage'),
			    	'from_user' => Auth::user()->id,
			    	'to_user' => $request->input('from_id_user')
			    ]);

	             if ( $sendM == true ) return redirect()->route('allMessages');
	}

	public function readedMessage(Request $request)
	{
		$idMessage = $request->input('idMessage');

		DB::table('messages')
		       ->where('message_id', '=', $idMessage)
		       ->update(['readed' => 0]);
	}

}