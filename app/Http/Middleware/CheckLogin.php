<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckLogin
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
        if(Auth::check()){
            if(Auth::user()->status==1){
                if(Auth::user()->role==1 || Auth::user()->role==2){
                    return $next($request);
                }else{
                    return redirect()->route('home');
                }
            }else{
                Auth::logout();
                return redirect()->route('login')->with('message_error','tài khoản của bạn đang bị khóa');
            }
        }else{
            return redirect()->route('login');
        }

    }
}
