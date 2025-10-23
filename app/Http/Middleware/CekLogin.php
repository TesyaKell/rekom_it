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

        if (!($response instanceof \Symfony\Component\HttpFoundation\BinaryFileResponse)) {
            $response->headers->add([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma'        => 'no-cache',
                'Expires'       => '0',
            ]);
        }
        return $response;

    }
}
