<?php

namespace App\Http\Middleware;

use Closure;

class StravaAuth
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

        $token = session('strava_token');

        if(is_null($token)){
            return redirect()->route('login');
        }

        $api = resolve('API');
        $api->setAccessToken(session('strava_token'));

        return $next($request);
    }
}
