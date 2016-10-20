<?

namespace App\Http\Controllers\Frontend\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{

	public function searchMain(Request $request)
	{
		$searchText =  $request->input('search');

		$data = \App\Reviews::where('title', 'LIKE', '%' . $searchText . '%')->get();

		return view('search.main', ['data' => $data]);
	}

}