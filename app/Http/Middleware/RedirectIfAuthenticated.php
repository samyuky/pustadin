<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if ($guard === 'admin' && Auth::guard($guard)->check()) {
                return redirect(route('admin.dashboard')); // Arahkan admin ke dashboard admin
            }
            if ($guard !== 'admin' && Auth::guard($guard)->check()) { // Untuk guard 'web' atau lainnya
                return redirect(RouteServiceProvider::HOME); // Arahkan pengguna biasa ke HOME
            }
        }

        return $next($request);
    }
}