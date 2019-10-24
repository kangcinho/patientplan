<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class CheckCanInsert
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
        if(Auth::user()->canInsert){
            return $next($request);
        }
        return response()->json([
            'error' => 'Anda Tidak Memiliki Akses Untuk Insert'
        ], 401);
    }
}
