<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Notification;

class CommentPostNotify
{
		private $text_blueprints = [
				'\App\Notifications\MentionedNotification' => '$[subject] te-a mentionat intr-un comentariu de-al lui.',
				'\App\Notifications\CommentRefferenceNotification' => '$[subject] a facut referire la un comentariu de-al tau intr-un comentariu de-al lui.',
				'\App\Notifications\ReplyRefferenceNotification' => '$[subject] a facut referire la un raspuns de-al tau intr-un comentariu de-al lui.',
		];
		
    public function handle($request, Closure $next)
    {
        $response = $next($request);
				
				/* @var notifications = [ ['class' => '\Notification\ClassName', 'to_user' => target_user_id], ... ]; */
				$notifications = \App\Classes\TextParser::parseForTags($request->title . ' ' . $request->text);
				$auth_id = Auth::id();
				$url = $request->url() . '/' . $request->post_id;
				//return response()->json($notifications);
				foreach ($notifications as $notification){
					if ($notification['to_user'] === $auth_id) continue;
					// verifica daca exista deja notificarea
					$duplicateNotification = \App\Notifications::where([
						'type' => $notification['class'],
						'from' => $auth_id, 
						'notifiable_id' => $notification['to_user'],
						'at_post_id' => $request->post_id
					])->count() > 1;
					
					//send notifications depending on class
					if (! $duplicateNotification ){
						Notification::send( \App\User::find($notification['to_user']), new $notification['class']([
							'text' => $this->text_blueprints[$notification['class']],
							'link' => $request->url(), //montat cumva,
							'at_post_id' => $request->post_id
						]));					
					}
				}

        return $response;
    }
}