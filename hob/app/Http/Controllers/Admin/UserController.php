<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role_uti !== 'admin') {
                return redirect()->route('visitor')->with('error', 'Accès non autorisé');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $users = Utilisateur::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }
}
