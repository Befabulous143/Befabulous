<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class TrustToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        set_time_limit(0);
        $session = Session::get('response_data') ?? '';
        if($session){
            $request->headers->set('cap_authorization', $session[0]['token']);
            $request->headers->set('cap_brand', config('app.brand'));
            $request->headers->set('cap_mobile', $session[0]['cap_mobile']);
            $request->headers->set('cap_device_id', $request->header('user-agent'));
            return $next($request);
        }
        
        return redirect(RouteServiceProvider::HOME)->with('false', 'Session Timeout! Please try again.');
    }
}
