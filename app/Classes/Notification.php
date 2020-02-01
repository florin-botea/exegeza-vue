<?php

namespace App\Classes;

use App\Classes\TextParser;
use Illuminate\Support\Facades\Auth;

class Notification
{
	private $notifications = [];
	
	/*
		adaug o lista cu notificari de trimis pe modelul
		[
			'notificationfullclassname' => [...user_ids],
			...etc
		]
	*/
	
	public function add($notifications){
		foreach($notifications as $notification => $to_user){
			if (! array_key_exists($notification, $this->notifications) ){
				$this->notifications[$notification] = [];
			}
			$this->notifications[$notification][] = $to_user;
		}
	}
	
	public function sendWithData($data){
		foreach($this->notifications as $notification_class => $users){
			foreach($users as $user_id){
				\Notification::send( \App\User::find($user_id), new $notification_class($data));
			}
		}
	}
}