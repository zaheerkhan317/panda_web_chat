<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use Cache;
use App\User;
use Carbon\Carbon;

class LastActivity
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
        if (Auth::check()) {
            $expireTime = Carbon::now()->addSeconds(10); // keep online for 2 minutes (2 seconds * 60 = 120 seconds)

            Cache::put('is_online'.Auth::user()->id, true, $expireTime);

            //Last Seen
            User::where('id', Auth::user()->id)->update(['last_seen' => Carbon::now()]);
        }
        return $next($request);
    }
}
