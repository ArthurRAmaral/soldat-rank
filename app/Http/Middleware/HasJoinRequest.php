<?php

namespace App\Http\Middleware;

use App\Models\JoinRequest;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HasJoinRequest
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
        $joinRequestExists = JoinRequest::where('clan_id', '=', $request->joinClanId)
                    ->where('user_id', '=', Auth::id())
                    ->first();
        
        if($joinRequestExists == null){
            return $next($request);
        }

        abort(403, "Você não pode fazer isso!");
        
    }
}
