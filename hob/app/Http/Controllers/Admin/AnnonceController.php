<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use Illuminate\Http\Request;

class AnnonceController extends Controller
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
        $annonces = Annonce::latest()->paginate(10);
        return view('admin.listings.index', compact('annonces'));
    }

    public function show($id)
    {
        $annonce = Annonce::findOrFail($id);
        return view('admin.listings.show', compact('annonce'));
    }
}
