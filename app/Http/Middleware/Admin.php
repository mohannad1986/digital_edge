<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\HasApiTokens;


class Admin
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

        if( auth('sanctum')->user()->Admen ==0){

            return response()->json('this is ADMIN reagon get out now out out !!!',405);


        }
        return $next($request);
    }
}
