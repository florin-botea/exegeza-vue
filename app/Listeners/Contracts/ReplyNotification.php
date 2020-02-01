<?php

namespace App\Listeners\Contracts;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \App\Traits\TextParserTrait;
use \App\Classes\Notification;

abstract class ReplyNotification
{
	use TextParserTrait;
		
    public function handle($event)
    {
		$related_model = $event->reply->re_reply ? \App\Reply::find($event->reply->re_reply) : \App\Comment::find($event->reply->comment_id); 
		$url_params = [
			'version' => 1,
			'book' => floor($event->reply->comment->target/1000000),
			'chapter' => floor( ($event->reply->comment->target%1000000)/1000 ),
			'g_verse' => $event->reply->comment->target,
			'comment' => $event->reply->comment->id,
			'reply' => $event->reply->id
		];
		$data = [
			'related_model' => get_class($related_model),
			'related_model_id' => $related_model->id,
			'url_params' => serialize($url_params)
		];
		$touched_users = $this->parseForTags($event->reply->text);
		$touched_users['re_to'] = [$event->reply->comment->author];
		if($event->reply->re_reply){
			$touched_users['re_to'][] = \App\Reply::findOrFail($event->reply->re_reply)->author;
		}
		
		$this->send($touched_users, $data);
    }
	abstract function send($touched_users, $data);
}
