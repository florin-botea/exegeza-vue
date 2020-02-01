<?php 

namespace App\Traits;

trait TextParserTrait 
{
	public function parseForTags($text){
		$auth_id = auth()->id();
		$host = request()->getHost();
		$users = [];
		$comments = [];
		$replies = [];
		preg_match_all('/\n+[ \t]*\[(\d+)\]\: *(url|user|note)\((.*)\)/', $text, $footers);
		foreach($footers[2] as $i => $res_type){
			if ($res_type == 'user'){
				if ($footers[3][$i] && $footers[3][$i] != $auth_id){
					$users[] = $footers[3][$i];
				}
			}
			if ($res_type == 'url'){
				$url = parse_url($footers[3][$i] ?? 'http://www.example.com');
				if ($url['host'] == $host){
					if (preg_match('/reply=(\d+)/', $footers[3][$i], $m )){
						$replies[] = $m[1];
					} elseif (preg_match('/comment=(\d+)/', $footers[3][$i], $m )){
						$comments[] = $m[1];
					}
				}
			}
		}
		$toucher_users = [
			'mentioned' => $users,
			'comment_reference' => [],
			'reply_reference' => [],
		];
			// gasesc id-uri useri in baza id-urilor de comentarii taguite
			// !!! nu pot fi taguite comentarii si raspunsuri sterse !!! m-am pacalit de doua ori
		if (count($comments) > 0){
			$comm_authors = \App\Comment::whereIn('id', $comments)->pluck('author')->toArray();
			$toucher_users['comment_reference'] = array_unique(
				array_filter($comm_authors, function($user) use ($auth_id){
					return $user != $auth_id;
				})
			);
		}
			// gasesc id-uri useri in baza id-urilor de raspunsuri taguite
		if (count($replies) > 0){
			$replies_authors = \App\Reply::whereIn('id', $replies)->pluck('author')->toArray();
			$toucher_users['reply_reference'] = array_unique(
				array_filter($replies_authors, function($user) use ($auth_id){
					return $user != $auth_id;
				})
			);
		}
		return $toucher_users;
	}
}