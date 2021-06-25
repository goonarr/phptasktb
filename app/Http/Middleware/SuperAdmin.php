<?php
namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Exception;

class SuperAdmin
{

	/**
	 * Handle an incoming request.
	 * Check if user has sufficent role: Super Admin
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		try{
			$user_obj = Auth::user();
		} catch(Exception $e){
			return abort(403);
		}

		if ( !$user_obj->isSuperAdmin() ) return abort(403);

		return $next($request);
	}
}
