<?

namespace App\Http\Controllers\Frontend\Users;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

	public function postAuthIndex(Request $request)
	{
		if ( Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')]) )
		{
			return redirect()->route('indexPage');
		} else {
			return redirect()->back()->withErrors('Невернный логин или пароль');
		}
	}

	public function getRegisterIndex()
	{
		if ( Auth::check() ) return redirect()->route('indexPage');
		else return view('user.register');
	}

	public function postRegisterIndex(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|unique:users,email',
			'password' => 'required|max:30|confirmed',
			'login' => 'required|max:30|unique:users,login',
			'g-recaptcha-response' => 'required|captcha'
		]);

		$registerUser = new User;

		if ( $request->login != null ) {
			$registerUser->login = $request->input('login');
		}
		if ( $request->input('vkRegister') != null ) {
			$registerUser->vk = $request->input('vkRegister');
		}
		if ( $request->input('aboutMeRegister') != null ) {
			$registerUser->about = $request->input('aboutMeRegister');
		}

		$registerUser->email = $request->input('email');
		$registerUser->password = bcrypt($request->input('password'));
		$registerUser->ip = $request->ip();
		$registerUser->save();

		return redirect()->route('indexPage');
	}

	public function getLogout()
	{

		Auth::logout();

		return redirect()->route('indexPage');
	}

}