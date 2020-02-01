<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class NotifyTouchedUsers
{
	private $textmap = [
		'clasalucutare' = > 'Utilizatorul !from! te-a mentionat pe tine sau o postare de-a ta intr-o postare de-a lui'
	];
	
    public function handle($request, Closure $next)
    {
        $response = $next($request);
		
		$notifications = null;
        switch ('route'){
			case 'comments':
				$notifications = \App\Classes\TextParser::parseForTags($request->title . ' ' . $request->text);
			break;
			case 'replies':
				$notifications = \App\Classes\TextParser::parseForTags($request->title . ' ' . $request->text);
				$notifications['class-ul la notificatia pt replied'] = \App\Comments::find($request->target)->author();
			break;
		}
		
		if ($response != null){
			foreach ($response as $key => $value){
				Notification::send( \App\User::find($value), new $key([
					'text' => $this->textmap[$key],
					'link' => $request->url() //montat cumva
				]));
			}
		}

        return $response;
    }
}