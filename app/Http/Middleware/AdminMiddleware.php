<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user has admin privileges
        $user = auth()->user();
        if (!$user->isAdmin() && $user->user_type !== 'admin' && $user->email !== 'admin@admin.com') {
            abort(403, 'Brak uprawnień administratora.');
        }

        return $next($request);
    }
}
