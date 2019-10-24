<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class CheckCanEkspor
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
        if(Auth::user()->canEkspor){
            return $next($request);
        }
        return response()->json([
            'error' => 'Anda Tidak Memiliki Akses Untuk Ekspor'
        ], 401);
    }
}
