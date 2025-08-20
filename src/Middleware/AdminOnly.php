<?php

namespace Probytech\Proadmin\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Probytech\Proadmin\Models\Role;

class AdminOnly
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
			public function handle($request, Closure $next, $guard = null)
	{
		$user = Auth::user();

		if ($user == null || $user->roles_id != Role::ADMIN) {
			return redirect()->route('admin-login');
		}

		return $next($request);
	}
}
