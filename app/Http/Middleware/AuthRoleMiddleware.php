<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware multi-guard: cek apakah request memiliki guard yang sesuai.
 *
 * Penggunaan di route:
 *   ->middleware('auth.role:admin')
 *   ->middleware('auth.role:mitra')
 *   ->middleware('auth.role:customer')
 */
class AuthRoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Tentukan guard berdasarkan role
        $guard = match ($role) {
            'admin'    => 'admin',
            'mitra'    => 'mitra',
            'customer' => 'customer',
            default    => 'customer',
        };

        if (!auth($guard)->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Set guard yang aktif di request agar bisa dipakai di controller via auth()->user()
        auth()->shouldUse($guard);

        return $next($request);
    }
}
