<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class AuthTeacher
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
        if (!User::isTeacher()) {
            abort(403, 'Error message');
//            User::logout();
//            return redirect(route('login.index'));
        }
        return $next($request);
    }
}
