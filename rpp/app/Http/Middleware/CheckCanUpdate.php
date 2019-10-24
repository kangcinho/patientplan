<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class CheckCanUpdate
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
        if(Auth::user()->canUpdate){
            return $next($request);
        }
        return response()->json([
            'error' => 'Anda Tidak Memiliki Akses Untuk Update'
        ], 401);
    }
}
