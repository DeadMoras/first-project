<?

namespace App\Http\Controllers\Backend\MainAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{

	public function getIndex()
	{
		$commentsCount = \App\Comments::count();
		$reviewsCount = \App\Reviews::count();
		$subscribeCount = \App\Subscribe::count();

		$users = \App\User::select('id', 'login', 'email', 'ip', 'roles', 'vk', 'about', 'created_at')->paginate(20);

		return view('admin.main', [
				'users' => $users,
				'cC' => $commentsCount,
				'rC' => $reviewsCount,
				'sC' => $subscribeCount
			]);
	}

}