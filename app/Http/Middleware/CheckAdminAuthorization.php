<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class CheckAdminAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  \App\Model\Lookups\Role $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user_role = Auth::user()->role_id;
        if ($role != $user_role) {
            return redirect('/admin');
        }
        return $next($request);
    }
}
