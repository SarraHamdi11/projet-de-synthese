<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!in_array($user->role_uti, $roles)) {
            // Redirect based on user's actual role
            switch ($user->role_uti) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'proprietaire':
                    return redirect()->route('proprietaire.accueilproprietaire');
                case 'locataire':
                case 'colocataire':
                    return redirect()->route('locataire.accueillocataire');
                default:
                    return redirect()->route('visitor');
            }
        }

        return $next($request);
    }
}
