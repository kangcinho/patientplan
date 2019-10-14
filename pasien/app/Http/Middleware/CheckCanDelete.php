<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class CheckCanDelete
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
        if(Auth::user()->canDelete){
            return $next($request);
        }
        return response()->json([
            'error' => 'Anda Tidak Memiliki Akses Untuk Delete'
        ], 401);
    }
}
