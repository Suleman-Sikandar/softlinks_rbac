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
        if (! Auth::guard('admin')->check()) {
            abort(404); 
        }
        if(Auth::guard('admin') && !\validatePermissions($request->route()->uri())){
            abort(403);
        }
        return $next($request);
    }
}
