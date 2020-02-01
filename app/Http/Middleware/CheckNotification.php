<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;

class CheckNotification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$notification_id = request()->query('notification-id', null);
		if ( $notification_id && Auth::check() ){
			$notif = Auth::user()->unreadNotifications()->find($notification_id);
			if ($notif) $notif->markAsRead();
		}
		return $next($request);
	}
}

