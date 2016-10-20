<?

namespace App\Http\Controllers\Frontend\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use \App\Http\Controllers\Frontend\News\AbstrNews;

class NewsController extends Controller
{

	public function getIndex()
	{
		return view('news.index');
	}

	public function newsAll(Request $request)
	{		
		$skipNews = $request->input('skip');
		$sort = $request->input('sort');

		$all = new AbstrNews();

		return $all->returnNews($skipNews, $sort);
	}

	public function getComments(Request $request)
	{
		$id = $request->input('newId');

		$comments = new AbstrNews();

		return $comments->loadComments($id);
	}

	public function sendLikeNews(Request $request)
	{
		$like = new AbstrNews();
		return $like->sendLike($request->all());
	}

	public function postAdd(Request $request)
	{

		$saveNews = DB::table('news')
			          ->insert([
				          	'title' => $request->input('newsTitle'),
				          	'description' => $request->input('descriptionNews'),
				          	'user_id' => $request->input('userId')
			          	]);

	             if ( $saveNews == true ) return response()->json(['success' => 'Успешное добавление']);
	             else return response()->json(['error' => 'Возникла ошибка']);
	}

	public function getShowNews($id)
	{
		$eachNews = new AbstrNews();

		$data = $eachNews->getEach($id);

		return view('news.each', ['data' => $data]);
	}

	public function getCommentsEach(Request $request)
	{
		$skippComments = $request->input('skip');

		$id = $request->input('newsId');

		$commentsToEach = new AbstrNews();

		return $commentsToEach->commentsEach($id, $skippComments);
	}

	public function sendCommentNews(Request $request)
	{
		$commentBody = $request->input('commentHey');
		$userId = $request->input('userId');
		$newId = $request->input('newsId');
		$toUserId = $request->input('answerTouUserId');

		$save = new AbstrNews();

		return $save->saveComment($commentBody, $userId, $newId, $toUserId);

	}

	public function deleteTheme(Request $request)
	{
		$themeId = $request->input('themeId');

		$delete = DB::table('news')
			          ->where('news.news_id', '=', $themeId)
			          ->delete();

	             if ( $delete == true ) return response()->json(['success' => 'Вы успешно удалили тему']);
	             else return response()->json(['error' => 'Произошла ошибка']);
	}

	public function commentLike(Request $request)
	{
		$likeableComment = $request->input('likeableComment');
		$idCommentLike = $request->input('idCommentLike');
		$whoSended = $request->input('userId');

		$commentLikes = new AbstrNews;

		return $commentLikes->likeOnComment($likeableComment, $idCommentLike, $whoSended);
	}

	public function editTitle(Request $request)
	{
		if ( \Auth::check() ) {
			$getEdit = DB::table('news')
				            ->where('news.news_id', $request->input('newTitleForNewId'))
				            ->update([
					            	'title' => $request->input('newTitleForNew')
				            	]);

		             if ( $getEdit == true ) return response()->json(['success' => 'Вы успешно изменили название']);
		             else return response()->json(['error' => 'Возникла ошибка']);
		} else {
			return response()->json(['error' => 'Ошибка']);
		}
	}

}