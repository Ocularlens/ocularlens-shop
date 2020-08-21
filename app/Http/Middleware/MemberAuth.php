<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate;

use Closure;

class MemberAuth extends Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('home.login');
        }
    }
}
