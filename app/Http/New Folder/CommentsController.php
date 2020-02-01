<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comments;
use App\Http\Requests\CommentPost;
use Notification;
use App\Tag_list;

class CommentsController extends Controller
{

	public function __construct(){

	}

	public function commentss($text){
		$auth = Auth::id();
		$comments = Comments::with('author')
			->withCount('replies')
			->with('tags.details')
			->when($auth, function($q) use ($auth){
				return $q->with(['auth_flag' => function($q) use ($auth){
					return $q->where('author', $auth);
				}]);
		})->where('target', $text)->paginate(3);
		return response()->json($comments);
	}
	
	public static function comments($text, $ref_comment = 0){
		$chunks = 3;
		if ($ref_comment > 0){
			//if notification get specified comment with its page
			$comments_before = Comments::where([ ['target', $text], ['id', '<', $ref_comment] ])->count();
			$currentPage = ceil($comments_before / $chunks);
			\Illuminate\Pagination\Paginator::currentPageResolver(function () use ($currentPage) {
				return $currentPage;
			});
		}
		
		$auth = Auth::id();
		return Comments::with('author')
			->withCount('replies')
			->with('tags.details')
			->when($auth, function($q) use ($auth){
				return $q->with(['auth_flag' => function($q) use ($auth){
					return $q->where('author', $auth);
				}]);
		})->where('target', $text)->paginate($chunks)->withPath('/texts/'.$text.'/comments');
	}
	
	public function create(CommentPost $request){ // adaug author in request la middleware/validare daca e user ok, la fel si la tags https://stackoverflow.com/questions/31850622/modify-input-before-validation-on-laravel-5-1
		$comment = Comments::create( $request->all() );
		$post_url = preg_replace('/\?.*/', '', url()->previous()) .'?comment='. $comment->id;
		\App\Classes\Notification::onPostComment($comment)->sendWithUrl($post_url);
		
		//$request->merge(['post_id' => $comment->id]); // set post_id for notification
		
		/*$comment->tags()->createMany($request->tags());
		$comment->flags()->createMany($request->flags());
		Notification::send($users, new \App\Notifications\MentionedNotification([
			'text' => 'Utilizatorul x te-a mentionat pe tine sau o postare de-a ta intr-o postare de-a lui',
			'link' => $link
		]));*/
		return response()->json( $this->_find($comment->id) );
	}
	
	public function _find($comment_id){
		$auth = Auth::id();
		return Comments::with('author')
			->withCount('replies')
			->with('tags.details')
			->when($auth, function($q) use ($auth){
				return $q->with(['auth_flag' => function($q) use ($auth){
					return $q->where('author', $auth);
				}]);
		})->find($comment_id);
	}
	
	public function destroy($comment_id){
		\App\Comments::find($comment_id)->delete();
		return response()->json(true);
	}
	
	public function update ($comment_id){
		
	}

	
	public function deleteComment($comment_id){
		\App\Comments::find($comment_id)->delete();
		echo 'deleted';
	}
	
	public function deleteReply($reply_id){
		\App\Replies::find($reply_id)->delete();
		echo 'deleted';		
	}
	
	// public function sendNotifications ($text, $link, $default = null){
		// if ($default !== null){
			// \App\User::find($default['user'])->notify(new \App\Notifications\MentionedNotification($default['data']));
		// }
		// $tagged = \App\Classes\TextParser::parseForTags($text);
		// $users = \App\User::find( array_unique( array_merge($tagged['user'], $tagged['comm'], $tagged['reply']) ));
		// if ($users == null || empty($users)){
			// return;
		// }
		// Notification::send($users, new \App\Notifications\MentionedNotification([
			// 'text' => 'Utilizatorul x te-a mentionat pe tine sau o postare de-a ta intr-o postare de-a lui',
			// 'link' => $link
		// ]));
	// }
	
}

function inspects($data, $json = false){
	?>
	<pre>
	<?php
		if($json === true){
			print_r(json_encode($data, JSON_PRETTY_PRINT));
			return;
		}
		print_r($data);
	?>
	<pre>
	<?php
}