<?php

namespace App\Http\Middleware;

use Closure;

class AlreadyAdminLoginMiddleware
{
    public function handle($request, Closure $next)
    {
        // ログイン済み
        if(session()->has('id') && session()->get('role') == 'admin'){
            return redirect(url('/'));
        }

        return $next($request);
    }
}
