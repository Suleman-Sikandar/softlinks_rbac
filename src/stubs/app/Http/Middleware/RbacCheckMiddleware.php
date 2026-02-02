<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RbacCheckMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Permission check
        if(Auth::guard('admin')->check() && !\validatePermissions($request->route()->uri())){
            abort(403);
        }
        return $next($request);
    }
}
