<?php

namespace App\Http\Middleware;

use Closure;
use App\Website;

class Token
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
        if( !Website::where("token" , $request->token)->first() ){
            return abort(404);
        }

        return $next($request);
    }
}
