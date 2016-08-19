<?php

namespace tencotools\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BlockedUser
{
    
    protected $blocklist = [
        'annelouise@tenco.se',
        'anne-louise@tenco.se',
        'magnus@tenco.se'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        //if (in_array(\Auth::user('email'), $blocklist))
        //{
            //\Auth::logout();
            #echo Auth::id();

        //}
        return $next($request);

    }
}
