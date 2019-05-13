<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        switch ($guard) {
            case 'admin':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('admin.dashboard');
                }
                break;
            default:
                if (Auth::guard($guard)->check()) {
                    
                    $last_project = $request->session()->pull('redirect_router_project');
                    return $last_project?redirect($last_project):redirect()->route('home');
                }
                break;
        }
        if($guard != 'admin'){
            if($request->email and Auth::guard($guard)->check()){
                $confirmed = User::where('email',$request->email)->first();
                if($confirmed->confirm_email_status === 0){
                    return back()->with('status','Подвердите почту. Ссылка для подтверждения отправлена Вам на почту.');
                }
            }
        }
        return $next($request);
    }
}
