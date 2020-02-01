<?php

namespace App\Classes;

class TextParser 
{
	public static function parseForTags($text){
		$map = [
				'user' => '\App\Notifications\MentionedNotification',
				'comm' => '\App\Notifications\CommentRefferenceNotification',
				'reply' => '\App\Notifications\ReplyRefferenceNotification',
		];
		
		preg_match_all('/#\[(user|comm|reply)=(\d+)?-?(\d+)?-?([ *[a-zA-Z0-9\-\>]+)?\]{([ *[a-zA-Z0-9\-\>\\n\\r]+)}/', $text, $tags);
		$notifications = [
			'user' => [],
			'comm' => [],
			'reply' => [],
		];
		for( $i=0; $i<count($tags[0]); $i++ ){
			$tag = $tags[1][$i];
			$notifications[$tag][] = $tags[2][$i];
		}
		// gasesc id-uri useri in baza id-urilor de comentarii taguite
		// !!! nu pot fi taguite comentarii si raspunsuri sterse !!! m-am pacalit de doua ori
		if (count($notifications['comm'])>0){
			$comm_authors = \App\Comments::whereIn('id', $notifications['comm'])->pluck('author');
			$notifications['comm'] = [];
			foreach( $comm_authors as $author ){
				$notifications['comm'][] = $author;
			}
		}
		// gasesc id-uri useri in baza id-urilor de raspunsuri taguite
		if (count($notifications['reply'])>0){
			$replies_authors = \App\Replies::whereIn('id', $notifications['reply'])->pluck('author');
			$notifications['reply'] = [];
			foreach( $replies_authors as $author ){
				$notifications['reply'][] = $author;
			}
		}
		
		$classed_notifications = [];
		foreach ($notifications as $tag_type => $users){
			foreach ($users as $user){
				$classed_notifications[] = [
					'class' => $map[$tag_type], 
					'to_user' => $user
				];
			}
		}
		
		return $classed_notifications;
	}
	
}