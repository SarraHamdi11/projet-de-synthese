<?php

namespace App\Http\Controllers\proprietaire;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Logement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnoncepropController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role_uti !== 'proprietaire') {
                return redirect()->route('visitor')->with('error', 'Accès non autorisé');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $annonces = Annonce::whereHas('logement', function($query) {
            $query->where('proprietaire_id', Auth::id());
        })->with('logement')->latest()->paginate(10);
        
        // Get statistics
        $totalAnnonces = Annonce::whereHas('logement', function($query) {
            $query->where('proprietaire_id', Auth::id());
        })->count();
        
        $activeAnnonces = Annonce::whereHas('logement', function($query) {
            $query->where('proprietaire_id', Auth::id());
        })->where('disponibilite_annonce', true)->count();
        
        return view('proprietaire.annonces.index', compact('annonces', 'totalAnnonces', 'activeAnnonces'));
    }

    public function create($logement_id)
    {
        $logement = Logement::findOrFail($logement_id);
        
        if ($logement->proprietaire_id !== Auth::id()) {
            return redirect()->route('proprietaire.logements.index')->with('error', 'Accès non autorisé');
        }
        
        return view('proprietaire.annonces.create', compact('logement'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'logement_id' => 'required|exists:logements,id',
            'titre_annonce' => 'required|string|max:255',
            'description_annonce' => 'required|string',
            'disponibilite' => 'required|boolean',
        ]);

        $logement = Logement::findOrFail($request->logement_id);
        
        if ($logement->proprietaire_id !== Auth::id()) {
            return redirect()->route('proprietaire.logements.index')->with('error', 'Accès non autorisé');
        }

        Annonce::create([
            'logements_id' => $request->logement_id,
            'titre_annonce' => $request->titre_annonce,
            'description_annonce' => $request->description_annonce,
            'disponibilite_annonce' => $request->disponibilite,
            'date_creation_annonce' => now(),
        ]);

        return redirect()->route('proprietaire.annonces.index')->with('success', 'Annonce créée avec succès');
    }
}
