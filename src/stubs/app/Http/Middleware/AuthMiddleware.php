<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Authentication Check
        if (! Auth::guard('admin')->check()) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
            return redirect()->to('login');
        }

        // 2. Permission check
        if(!\validatePermissions($request->route()->uri())){
            abort(403);
        }
        return $next($request);
    }
}
