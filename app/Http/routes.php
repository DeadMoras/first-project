<?php


Route::get('/logout', ['uses' => '\App\Http\Controllers\Frontend\Users\AuthController@getLogout', 'as' => 'logoutUser']);

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
    'uses' => '\App\Http\Controllers\Frontend\Reviews\ReviewsController@getIndex',
    'as' => 'indexPage'
]);
Route::get('/moreReviews', [
    'uses' => '\App\Http\Controllers\Frontend\Reviews\ReviewsController@moreScrollReviews',
]);


//AuthController
Route::post('/', [
	'uses' => '\App\Http\Controllers\Frontend\Users\AuthController@postAuthIndex',
	'as' => 'postAuth'
]);
Route::get('/register', [
	'uses' => '\App\Http\Controllers\Frontend\Users\AuthController@getRegisterIndex'
]);
Route::post('/register', [
	'uses' => '\App\Http\Controllers\Frontend\Users\AuthController@postRegisterIndex',
	'as' => 'postRegister'
]);

//UserController
Route::get('/profile', [
	'uses' => '\App\Http\Controllers\Frontend\Users\UserController@getProfile',
	'as' => 'profileUser'
]);
Route::post('/profile/getUpdate', [
	'uses' => '\App\Http\Controllers\Frontend\Users\UserController@getUpdateProfile',
	'as' => 'getUpdateProfile'
]);
Route::post('/profile/update', [
	'uses' => '\App\Http\Controllers\Frontend\Users\UserController@postUpdateProfile',
	'as' => 'updateProfile'
]);
Route::post('/profile/updateAvatar', [
	'uses' => '\App\Http\Controllers\Frontend\Users\UserController@updateImgUser',
	'as' => 'updateAvatar'
]);
Route::get('/user/id{id}', [
	'uses' => '\App\Http\Controllers\Frontend\Users\UserController@getUserProfile',
	'as' => 'userProfile'
]);

//ReviewsController
Route::get('/review/{slowtitle}', [
	'uses' => '\App\Http\Controllers\Frontend\Reviews\ReviewsController@getEachReview',
	'as' => 'eachReview'
]);



//CommentsController
Route::get('/review/{id}/comments', [
	'uses' => '\App\Http\Controllers\Frontend\Comments\CommentsReviewController@getComments',
	'as' => 'commentsReview'
]);
Route::post('/review/{id}/comments', [
	'uses' => '\App\Http\Controllers\Frontend\Comments\CommentsReviewController@postAddComment',
	'as' => 'commentAdd'
]);;
Route::post('/delete_comment', [
	'uses' => '\App\Http\Controllers\Frontend\Comments\CommentsReviewController@deleteComment',
	'as' => 'deleteComment'
]);
Route::post('/show_modal_comment', [
	'uses' => '\App\Http\Controllers\Frontend\Comments\OtherCommentsController@modalComment',
]);
Route::post('/show_modal_comment_your', [
	'uses' => '\App\Http\Controllers\Frontend\Comments\OtherCommentsController@yourModalComment',
]);



//LikesController
Route::post('/likes', [
	'uses' => '\App\Http\Controllers\Frontend\Likes\LikesController@sendLike',
	'as' => 'sendLike'
]);


//SubscribeController
Route::post('/subscribe_user', [
	'uses' => '\App\Http\Controllers\Frontend\Subscribe\SubscribeController@subscribe',
	'as' => 'subscribeUser'
]);
Route::post('/subscribed_user', [
	'uses' => '\App\Http\Controllers\Frontend\Subscribe\SubscribeController@subscribed',
	'as' => 'subscribeUser'
]);

//SearchController
Route::get('/search', [
	'uses' => '\App\Http\Controllers\Frontend\Search\SearchController@searchMain'
]);


//MessagesController
Route::get('/messages', [
	'uses' => '\App\Http\Controllers\Frontend\Messages\MessagesController@messagesIndex',
	'as' => 'allMessages'
]);
Route::get('/message/{id}', [
	'uses' => '\App\Http\Controllers\Frontend\Messages\MessagesController@getEachMessage',
	'as' => 'messageEach'
]);
Route::post('/delete_message', [
	'uses' => '\App\Http\Controllers\Frontend\Messages\MessagesController@messageDelete'
]);
Route::post('/send_message', [
	'uses' => '\App\Http\Controllers\Frontend\Messages\MessagesController@messageSend',
	'as' => 'sendMessage'
]);
Route::post('/readed_message', [
	'uses' => '\App\Http\Controllers\Frontend\Messages\MessagesController@readedMessage'
]);
Route::get('/moreMessages', [
	'uses' => '\App\Http\Controllers\Frontend\Messages\MessagesController@moreMessages'
]);


//OtherMessageController
Route::post('/send_message_profile', [
	'uses' => '\App\Http\Controllers\Frontend\Messages\OtherMessagesController@messageSend'
]);
Route::get('/archive_messages', [
	'uses' => '\App\Http\Controllers\Frontend\Messages\OtherMessagesController@messageArchive'
]);
Route::get('/count_messages', [
	'uses' => '\App\Http\Controllers\Frontend\Messages\OtherMessagesController@getCountMessages'
]);


//NotificationsController
Route::get('/notifications', [
	'uses' => '\App\Http\Controllers\Frontend\Notifications\NotificationsController@getNotifications'
]);
Route::get('/profile/notifications', [
	'uses' => '\App\Http\Controllers\Frontend\Notifications\NotificationsController@getPageNotify'
]);
Route::post('/profile/notifications_delete', [
	'uses' => '\App\Http\Controllers\Frontend\Notifications\NotificationsController@getDeleteNotify'
]);
Route::post('/profile/notifications_readed', [
	'uses' => '\App\Http\Controllers\Frontend\Notifications\NotificationsController@getReaded'
]);


//News
//NewsController
Route::get('/news', [
	'uses' => '\App\Http\Controllers\Frontend\News\NewsController@getIndex',
	'as' => 'indexNews'
]);
Route::post('/add_news', [
	'uses' => '\App\Http\Controllers\Frontend\News\NewsController@postAdd',
	'as' => 'addNews'
]);
Route::get('/newsall', [
	'uses' => '\App\Http\Controllers\Frontend\News\NewsController@newsAll',
]);
Route::get('/comments_to_news', [
	'uses' => '\App\Http\Controllers\Frontend\News\NewsController@getComments',
]);
Route::post('/news_send_like', [
	'uses' => '\App\Http\Controllers\Frontend\News\NewsController@sendLikeNews',
]);
Route::get('/news/{id}', [
	'uses' => '\App\Http\Controllers\Frontend\News\NewsController@getShowNews',
]);
Route::get('/each_news_comments', [
	'uses' => '\App\Http\Controllers\Frontend\News\NewsController@getCommentsEach',
]);
Route::post('/new_comment_news', [
	'uses' => '\App\Http\Controllers\Frontend\News\NewsController@sendCommentNews',
]);
Route::post('/new_comment_likes', [
	'uses' => '\App\Http\Controllers\Frontend\News\NewsController@commentLike',
]);
Route::post('/deleteTheme', [
	'uses' => '\App\Http\Controllers\Frontend\News\NewsController@deleteTheme',
]);
Route::post('/editTitle', [
	'uses' => '\App\Http\Controllers\Frontend\News\NewsController@editTitle',
]);



//Admin
Route::group(['middleware' => ['auth', 'admin']], function() {
	Route::get('/admin', [
		'uses' => '\App\Http\Controllers\Backend\MainAdmin\AdminController@getIndex'
	]);
	Route::post('/admin/user_search', [
		'uses' => '\App\Http\Controllers\Backend\Search\SearchController@getUsers'
	]);
	Route::post('/admin/user_edit', [
		'uses' => '\App\Http\Controllers\Backend\Users\UserController@userEdit'
	]);
	Route::post('/admin/user_update', [
		'uses' => '\App\Http\Controllers\Backend\Users\UserController@userUpdate'
	]);
	Route::post('/admin/delete_user', [
		'uses' => '\App\Http\Controllers\Backend\Users\UserController@userDelete'
	]);
	Route::get('/admin/comments', [
		'uses' => '\App\Http\Controllers\Backend\Comments\CommentsController@getIndex',
		'as' => 'adminComments'
	]);
	Route::post('/admin/comments_search', [
		'uses' => '\App\Http\Controllers\Backend\Search\SearchController@getComments'
	]);
	Route::post('/admin/comments/delete_comment', [
		'uses' => '\App\Http\Controllers\Backend\Comments\CommentsController@deleteComment'
	]);
	Route::post('/admin/comments/edit_comment', [
		'uses' => '\App\Http\Controllers\Backend\Comments\CommentsController@editComment'
	]);
	Route::post('/admin/comments/save_new_comment', [
		'uses' => '\App\Http\Controllers\Backend\Comments\CommentsController@saveNewComment'
	]);
	Route::get('/admin/reviews', [
		'uses' => '\App\Http\Controllers\Backend\ReviewsAdmin\ReviewsAdminController@getIndex',
		'as' => 'adminReviews'
	]);
	Route::post('/admin/reviews_search', [
		'uses' => '\App\Http\Controllers\Backend\Search\SearchController@getReviews'
	]);
	Route::post('/admin/reviews_delete', [
		'uses' => '\App\Http\Controllers\Backend\ReviewsAdmin\ReviewsAdminController@deleteReview'
	]);
	Route::get('/admin/reviews/{id}/edit', [
		'uses' => '\App\Http\Controllers\Backend\ReviewsAdmin\ReviewsAdminController@getEdit'
	]);
	Route::post('/admin/reviews/{id}/edit', [
		'uses' => '\App\Http\Controllers\Backend\ReviewsAdmin\ReviewsAdminController@postEdit',
		'as' => 'adminEditReview'
	]);
	Route::get('/admin/reviews/add', [
		'uses' => '\App\Http\Controllers\Backend\ReviewsAdmin\ReviewsAdminController@getAdd'
	]);
	Route::post('/admin/reviews/add', [
		'uses' => '\App\Http\Controllers\Backend\ReviewsAdmin\ReviewsAdminController@postAdd',
		'as' => 'adminAddReview'
	]);
});