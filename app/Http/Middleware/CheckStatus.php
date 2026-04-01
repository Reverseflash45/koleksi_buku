<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckStatus
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->status == 'active') {
            return $next($request);
        }

        if ($request->user()->status == 'verify') {
            return redirect('/verify');
        }

        return $next($request);
    }
}