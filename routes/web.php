<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
//Route::get('/logout', 'Auth\LoginController@logout');

Route::resource('users', 'UserController');

Route::get('/users/name-suggestion/{qs}', 'UserController@nameSuggestion');

Route::get('/', 'BibleController@index');
Route::resource('traduceri', 'BibleController')->parameters([
    'traduceri' => 'traducere'
]);;

Route::resource('traduceri.carti', 'BookController')->parameters([
    'traduceri' => 'version', 'carti' => 'book'
]);

Route::resource('capitole', 'ChapterController')->parameters([
    'capitole' => 'capitol'
]);

Route::resource('traduceri.carti.capitole', 'ChapterController')->parameters([
    'traduceri' => 'version', 'carti' => 'book', 'capitole' => 'chapter'
]);

Route::resource('traduceri.carti.capitole.versete', 'VersesController')->parameters([
    'traduceri' => 'version', 'carti' => 'book', 'capitole' => 'chapter'
]);

Route::get('/search', 'BibleSearchController@index');

Route::resource('versete.comentarii', 'CommentController')->parameters([
	'comentarii' => 'comments'
]);
Route::resource('comentarii', 'CommentController')->parameters([
	'comentarii' => 'comment'
]);

Route::resource('comentarii.raspunsuri', 'ReplyController')->parameters([
	'comentarii' => 'comment', 'raspunsuri' => 'reply'
]);
Route::resource('raspunsuri', 'ReplyController')->parameters([
	'raspunsuri' => 'reply'
]);

Route::resource('comentarii.taguri', 'ModelHasTagController');
Route::resource('taguri', 'TagController');

Route::resource('sugestii', 'SuggestionController');

Route::resource('repports', 'RepportController');

Route::get('/notifications/check-for-new', 'NotificationController@checkForNew');
Route::get('/notifications/{id}', 'NotificationController@get');
Route::patch('/notifications', 'NotificationController@markAllAsRead');
Route::resource('notifications', 'NotificationController');

// Route::name('dev.')->group(/*['middleware' => 'dev'], */ function(){ //middleware authenticated, CheckIfDev
	Route::get('/db-up', 'Dev@dbUp');
	Route::get('/db-down', 'Dev@dbDown');
	Route::get('/db-fill', 'Dev@dbFill');
	Route::get('/dev/gain-permission/{permission}', 'Dev@gainPermission');
	Route::get('/test', 'Dev@test');
	Route::get('/sign', 'Sign@test');
	
Route::get('/bible-resources/{global_id}', function($global_id){
	$version = \App\Bible::firstOrFail();
	$book = \App\Book::where(['bible_id'=>$version->id,'index'=>floor($global_id/1000000)])->firstOrFail();
	$chapter = floor(($global_id%1000000)/1000);
	$verse = $global_id%1000;

	$base = '/traduceri/'.$version->slug.'/carti/'.$book->slug.'/capitole/';
	if ( $chapter > 0 ){
		$base .= ($chapter.'/versete');
	}
	$qs = [];
	if ( $chapter > 0 && $verse > 0 ){
		$qs['verse'] = $verse;
	}
	if ( request()->query('comment', 0) > 0 ){
		$qs['comment'] = request()->query('comment');
	}
	if ( request()->query('reply', 0) > 0 ){
		$qs['reply'] = request()->query('reply');
	}
	return redirect($base.'?'.http_build_query($qs));
});