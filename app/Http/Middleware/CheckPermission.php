<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
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
		$permisions = User::find(Auth::id())->permissions();
		if (! in_array(Request::route()->getName(), $permisions) ){
			return http_response_code(405);
		}
        return $next($request);
    }
}
