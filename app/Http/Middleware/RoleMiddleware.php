<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }    

        // Jika role tidak sesuai
        if (Auth::user()->role !== $role) {
            // Jika yang maksa masuk adalah admin, lempar ke dashboard admin
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            // Jika yang maksa masuk adalah intern, lempar ke dashboard intern
            return redirect()->route('intern.dashboard');
        }

        return $next($request);
    }
}