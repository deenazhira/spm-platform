<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsStudent
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasRole('student')) {
            return $next($request);
        }

        abort(403, 'Unauthorized access. Students only.');
    }
}
