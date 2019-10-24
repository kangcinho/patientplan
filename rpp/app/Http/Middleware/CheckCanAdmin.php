<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
class CheckCanAdmin
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
        if(Auth::user()->canAdmin){
            return $next($request);
        }
        return response()->json([
            'error' => 'Anda Tidak Memiliki Akses Untuk User Management'
        ], 401);
    }
}
