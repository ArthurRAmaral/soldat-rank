<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClanManager
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
        if(Auth::user()->clan_id && Auth::user()->is_clan_manager){
            return $next($request);
        }else{
            abort(403, "Somente membros autorizados podem realizar esta ação!");
        }
        
    }
}
