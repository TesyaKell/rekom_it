<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class cekLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('loginId') && !$request->is('login') && !$request->is('login/process')) {
            return redirect('/login');
        }

        if (session()->has('loginId') && $request->is('login')) {
            return redirect('/home');
        }

        $response = $next($request);
        return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', '0');
    }
}
