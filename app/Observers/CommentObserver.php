<?php

namespace App\Observers;

use App\Comment;
use App\Classes\Notification;
use App\Traits\TextParserTrait;

class CommentObserver
{
	use TextParserTrait;
	
	private $notifications;
	private $notificationData;
	private $touchedUsers = [];
	
	public function __construct(Notification $notificator){
		$this->notifications = $notificator;
	}
	
	private function created(Comment $comment){
		$this->notifications->add( ['\App\Notifications\IWasMentioned' => $this->touchedUsers['mentioned']] );
		$this->notifications->add( ['\App\Notifications\ReferredMyPost' => $this->touchedUsers['comment_reference']] );
		$this->notifications->add( ['\App\Notifications\ReferredMyPost' => $this->touchedUsers['reply_reference']] );
		$this->notifications->sendWithData($this->notificationData);
	}
	
	private function updated(Comment $comment){
		$this->notifications->add( ['\App\Notifications\EditedPostWhereIWasMentioned' => $this->touchedUsers['mentioned']] );
		$this->notifications->add( ['\App\Notifications\EditedPostWhereMineReferred' => $this->touchedUsers['comment_reference']] );
		$this->notifications->add( ['\App\Notifications\EditedPostWhereMineReferred' => $this->touchedUsers['reply_reference']] );
		$this->notifications->sendWithData($this->notificationData);
	}
	
	private function getUrlParams(Comment $comment){
		return [
			'version' => \App\Bible::firstOrFail()->id,
			'book' => floor($comment->target/1000000),
			'chapter' => floor( ($comment->target%1000000)/1000 ),
			'g_verse' => $comment->target,
			'comment' => $comment->id,
		];
	}
	
    public function __call($method,$arguments) {
        if(method_exists($this,$method)) {
            $comment = $arguments[0];
			$this->touchedUsers = $this->parseForTags($comment->text);
			$this->notificationData = [
				'related_model' => get_class($comment),
				'related_model_id' => $comment->id,
				'url_params' => serialize($this->getUrlParams($comment))
			];
            return call_user_func_array( [$this,$method], $arguments );
        }
    }
}
