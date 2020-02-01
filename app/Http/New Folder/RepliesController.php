<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReplyPost;
use App\Replies;
use Notification;

class RepliesController extends Controller
{
	private $replies;

	public function __construct(){

	}

	public static function replies($ref_comment, $ref_reply = 0){
		$chunks = 3;a
		if ($ref_reply > 0){
			//if notification get specified comment with its page
			$replies_before = Replies::where([ ['comment_id', $ref_comment], ['id', '<', $ref_reply] ])->count();
			$currentPage = ceil($replies_before / $chunks);
			\Illuminate\Pagination\Paginator::currentPageResolver(function () use ($currentPage) {
				return $currentPage;
			});
		}
		return Replies::with('author')->where('comment_id', $ref_comment)->paginate($chunks)->withPath('/comments/'.$ref_comment.'/replies');		
	}
	
	public function repliess($comment){
		$replies = Replies::with('author')->where('comment_id', $comment)->paginate(10);
		return response()->json($replies);		
	}
	
	public function create(ReplyPost $request){
		$reply = Replies::create( $request->all() );
		$data = Replies::with('author')->find($reply->id);
		/*$comment = \App\Comments::find($reply->target);
		//le trimit in middleware de final
		Notification::send($users, new \App\Notifications\MentionedNotification([
			'text' => 'Utilizatorul x te-a mentionat pe tine sau o postare de-a ta intr-o postare de-a lui',
			'link' => $link
		]));
		Notification::send($comment->, new \App\Notifications\RepliedNotification([
			'text' => 'Utilizatorul x a adaugat un raspuns la comentariul tau',
			'link' => $link
		]));*/
		
		return response()->json($data);
	}
	
	public function deleteComment($comment_id){
		\App\Comments::find($comment_id)->delete();
		echo 'deleted';
	}
	
	public function deleteReply($reply_id){
		\App\Replies::find($reply_id)->delete();
		echo 'deleted';		
	}
	
	public function sendNotifications ($text, $link, $default = null){
		if ($default !== null){
			\App\User::find($default['user'])->notify(new \App\Notifications\MentionedNotification($default['data']));
		}
		$tagged = \App\Classes\TextParser::parseForTags($text);
		$users = \App\User::find( array_unique( array_merge($tagged['user'], $tagged['comm'], $tagged['reply']) ));
		if ($users == null || empty($users)){
			return;
		}
		Notification::send($users, new \App\Notifications\MentionedNotification([
			'text' => 'Utilizatorul x te-a mentionat pe tine sau o postare de-a ta intr-o postare de-a lui',
			'link' => $link
		]));
	}
	
	private function archiveReply($comment){
		$path = '../storage/app/private/archives/Reply/'; //MAGIC
		$file_name = $comment->id . '_' . date("Y-m-d-h-m-s") . '.json';
		$fp = fopen($path . $file_name, 'w');
		fwrite($fp, json_encode($comment));
		fclose($fp);
	}	
}

function inspectss($data, $json = false){
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