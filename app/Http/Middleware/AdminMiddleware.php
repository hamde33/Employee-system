<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // التحقق: هل المستخدم مسجّل دخول؟ وهل دوره admin أو employee
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'employee'])) {
            return $next($request);
        }
    
        abort(403, 'Unauthorized action.');
    }
    
}
