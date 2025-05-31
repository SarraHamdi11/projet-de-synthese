<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                
                switch ($user->role_uti) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'proprietaire':
                        return redirect()->route('proprietaire.accueilproprietaire');
                    case 'locataire':
                    case 'colocataire':
                        return redirect()->route('locataire.accueillocataire');
                    default:
                        return redirect('/');
                }
            }
        }

        return $next($request);
    }
}