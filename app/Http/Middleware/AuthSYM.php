<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AuthController;
use Closure;

class AuthSYM
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if(!AuthController::check())
		{
			if($request->ajax() || $request->wantsJson())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return redirect()->guest('login');
			}
		}

		return $next($request);
	}
}
