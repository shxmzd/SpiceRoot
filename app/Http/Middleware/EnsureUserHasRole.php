<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Check if user has the required role
        if ($user->role !== $role) {
            // Redirect to appropriate dashboard based on user's actual role
            return $this->redirectToRoleDashboard($user->role);
        }

        return $next($request);
    }

    private function redirectToRoleDashboard($role)
    {
        return match($role) {
            'seller' => redirect()->route('seller.dashboard'),
            'buyer' => redirect()->route('buyer.dashboard'),
            default => redirect()->route('dashboard'), // fallback
        };
    }
}