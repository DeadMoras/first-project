<?

namespace App\Http\Controllers\Backend\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

	public function userEdit(Request $request)
	{
		$idUser = $request->input('dataIdBlock');

		$data = \App\User::where('id', $idUser)->first();

		return response()->json(['user' => $data]);
	}

	public function userUpdate(Request $request)
	{
		$user = \App\User::where('id', $request->input('userId'));

		$login = $request->input('loginUser');
		$vk = $request->input('vkUser');
		$email = $request->input('emailUser');
		$about = $request->input('aboutUser');
		$roles = $request->input('roleUser');

		$saveUser = $user->update([
				    'login' => $login,
				    'vk' => $vk,
				    'email' => $email,
				    'about' => $about,
				    'roles' => $roles
			         ]);

		if ( $saveUser == true ) return response()->json(['success' => 'Успешно обновил данные']);
		else return response()->json(['error' => 'Возникла ошибка']);
	}

	public function userDelete(Request $request)
	{
		$idUser = $request->input('userId');

		$deleteUser = \App\User::where('id', $idUser)->delete();

		if ( $deleteUser == true) return response()->json(['success' => 'aga']);
		else return response()->json(['error' => 'error']);
	}

}