<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // يجب أن يكون مسجّل الدخول وفي نفس الوقت admin
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'employee'])) {
            return $next($request);
        }

        // غير مسموح، أعرض صفحة 403 أو وجه رسالة خطأ
        abort(403, 'Unauthorized action.');
    }
}

