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
		
		//aici fac trb cu drepturile omului
		//fiecare user are un fuel tank...50 sa zicem, un post ii ia 15, un vot ii da 5, etc cand ajunge la nustucat, i se da un drept nou

        return $response;
    }
}