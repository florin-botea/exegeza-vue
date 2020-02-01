<?php

namespace App\Observers;

use App\ModelHasTag;
use App\Classes\Notification;

class TagObserver
{
	private $notifications;
	private $notificationData;
	private $touchedUsers = [];
	
	public function __construct(Notification $notificator){
		$this->notifications = $notificator;
	}
	
	private function created(ModelHasTag $tag){
		if ($tag->assigned_by == $tag->comment->author){
			return;
		}
		$this->notifications->add( ['\App\Notifications\TagOnMyPost' => [$tag->comment->author]] );
		$this->notifications->sendWithData($this->notificationData);
	}
	
	private function getUrlParams(ModelHasTag $tag){
		$target = $tag->comment->target;
		return [
			'version' => \App\Bible::firstOrFail()->id,
			'book' => floor($target/1000000),
			'chapter' => floor( ($target%1000000)/1000 ),
			'g_verse' => $target,
			'comment' => $tag->comment->id,
		];
	}
	
    public function __call($method,$arguments) {
        if(method_exists($this,$method)) {
            $tag = $arguments[0];
			$this->notificationData = [
				'related_model' => get_class($tag),
				'related_model_id' => $tag->id,
				'url_params' => serialize($this->getUrlParams($tag))
			];
            return call_user_func_array( [$this,$method], $arguments );
        }
    }
}
