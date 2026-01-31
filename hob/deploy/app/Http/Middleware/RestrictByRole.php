<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestrictByRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user || !in_array($user->role_uti, $roles)) {
            \Log::info('Unauthorized access attempt by user: ' . ($user->email_uti ?? 'unknown') . ' to role-restricted route');
            return redirect()->route('visitor')->with('error', 'Accès non autorisé.');
        }

        return $next($request);
    }
}