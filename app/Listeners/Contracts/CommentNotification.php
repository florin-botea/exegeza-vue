<?php

namespace App\Listeners\Contracts;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \App\Traits\TextParserTrait;
use \App\Classes\Notification;

abstract class CommentNotification
{
	use TextParserTrait;
		
    public function handle($event)
    {
		$related_model = $event->comment;
		$url_params = [
			'version' => 1,
			'book' => floor($event->comment->target/1000000),
			'chapter' => floor( ($event->comment->target%1000000)/1000 ),
			'g_verse' => $event->comment->target,
			'comment' => $event->comment->id,
		];
		$data = [
			'related_model' => get_class($related_model),
			'related_model_id' => $related_model->id,
			'url_params' => serialize($url_params)
		];
		$touched_users = $this->parseForTags($event->comment->text. '' .$event->comment->title);
		
		$this->send($touched_users, $data);
    }
	abstract function send($touched_users, $data);
}
