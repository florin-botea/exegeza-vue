<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class CustomDbChannel 
{

  public function send($notifiable, Notification $notification)
  {
    $data = $notification->toDatabase($notifiable);
		if ( isset($data['notification_aborted']) ){
			return null;
		}
		if (!$notifiable){
			echo 'Notifiable not found';
			return null;
		}
    return $notifiable->routeNotificationFor('database')->create([
        'type' => get_class($notification),
        'related_model' => $data['related_model'] ?? null,
        'related_model_id' => $data['related_model_id'] ?? null,
		'from' => $data['from'] ?? Auth::id(),
		'from_more' => $data['from_more'] ?? 0,
		//'at_post_id' => $data['at_post_id'] ?? 0,
		'text' => $data['text'] ?? '',
		'url_params' => $data['url_params'] ?? null,
		'read_at' => null
    ]);
  }

}