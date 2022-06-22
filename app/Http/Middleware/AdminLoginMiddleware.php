<?php

namespace App\Http\Middleware;

use Closure;

class AdminLoginMiddleware
{
    public function handle($request, Closure $next)
    {
        // 未ログイン
        if(!session()->has('id')){
            $request->session()->flash('message', 'ログインしてください');
            $request->session()->flash('type', 'danger');
            return redirect(url('/login'));
        }
        // セッションで管理権限がない場合
        else if(!session()->get('role') == 'admin'){
            $request->session()->flash('message', '管理権限ではありません');
            $request->session()->flash('type', 'danger');
            return redirect(url('/login'));
        }

        return $next($request);
    }
}
