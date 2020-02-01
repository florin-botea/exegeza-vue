<?php

namespace App\Observers;

use App\Reply;
use App\Classes\Notification;
use App\Traits\TextParserTrait;

class ReplyObserver
{
	use TextParserTrait;
	
	private $notifications;
	private $notificationData;
	private $touchedUsers = [];
	
	public function __construct(Notification $notificator){
		$this->notifications = $notificator;
	}
	
	private function created(Reply $reply){
		$this->notifications->add( ['\App\Notifications\RepliedToMyPost' => $this->touchedUsers['subposted']] );
		$this->notifications->add( ['\App\Notifications\IWasMentioned' => $this->touchedUsers['mentioned']] );
		$this->notifications->add( ['\App\Notifications\ReferredMyPost' => $this->touchedUsers['comment_reference']] );
		$this->notifications->add( ['\App\Notifications\ReferredMyPost' => $this->touchedUsers['reply_reference']] );
		$this->notifications->sendWithData($this->notificationData);
	}
	
	private function updated(Reply $reply){
		//$this->notifications->add( ['\App\Notifications\OnReplyEditedNotification' => $this->touchedUsers['subposted']] );
		$this->notifications->add( ['\App\Notifications\EditedPostWhereIWasMentioned' => $this->touchedUsers['mentioned']] );
		$this->notifications->add( ['\App\Notifications\EditedPostWhereMineReferred' => $this->touchedUsers['comment_reference']] );
		$this->notifications->add( ['\App\Notifications\EditedPostWhereMineReferred' => $this->touchedUsers['reply_reference']] );
		$this->notifications->sendWithData($this->notificationData);
	}
	
	private function getUrlParams(Reply $reply){
		$target = $reply->comment->target;
		return [
			'version' => \App\Bible::firstOrFail()->id,
			'book' => floor($target/1000000),
			'chapter' => floor( ($target%1000000)/1000 ),
			'g_verse' => $target,
			'comment' => $reply->comment->id,
			'reply' => $reply->id,
		];
	}
	
    public function __call($method,$arguments) {
        if ( method_exists($this,$method) ) {
            $reply = $arguments[0];
			$this->touchedUsers = $this->parseForTags($reply->text);
			$this->touchedUsers['subposted'] = [];
			if ($reply->comment->author !== auth()->id() ){
				$this->touchedUsers['subposted'][] = $reply->comment->author;
			}
			if ($reply->re_reply){
				if (Reply::find($reply->re_reply)->author !== auth()->id()){
					$this->touchedUsers['subposted'][] = Reply::find($reply->re_reply)->author;
				}
			}
			$this->notificationData = [
				'related_model' => get_class($reply),
				'related_model_id' => $reply->id,
				'url_params' => serialize($this->getUrlParams($reply))
			];
            return call_user_func_array( [$this,$method], $arguments );
        }
    }
}
