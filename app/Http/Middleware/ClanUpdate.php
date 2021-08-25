<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClanUpdate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(($request->clanId == Auth::user()->clan_id) && Auth::user()->is_clan_manager){
            return $next($request);
        }
        abort(403, 'Você está proibido de realizar esta ação!');
    }
}
