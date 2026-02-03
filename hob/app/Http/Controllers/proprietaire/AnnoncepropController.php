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
        
        return view('proprietaire.annoncesproprietaire.index', compact('annonces', 'totalAnnonces', 'activeAnnonces'));
    }

    public function create($logement_id)
    {
        try {
            $logement = Logement::findOrFail($logement_id);
            
            if ($logement->proprietaire_id !== Auth::id()) {
                return redirect()->route('proprietaire.logements')->with('error', 'Accès non autorisé à ce logement');
            }
            
            return view('proprietaire.annonces.create', compact('logement'));
        } catch (\Exception $e) {
            return redirect()->route('proprietaire.annoncesproprietaire.index')->with('error', 'Erreur lors du chargement du formulaire: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'logement_id' => 'required|exists:logements,id',
            'titre_anno' => 'required|string|max:255',
            'description_anno' => 'required|string',
            'disponibilite_annonce' => 'required|boolean',
        ]);

        try {
            $logement = Logement::findOrFail($request->logement_id);
            
            if ($logement->proprietaire_id !== Auth::id()) {
                return redirect()->route('proprietaire.annoncesproprietaire.index')->with('error', 'Accès non autorisé');
            }

            $annonce = new \App\Models\Annonce();
            $annonce->logement_id = $request->logement_id;
            $annonce->titre_anno = $request->titre_anno;
            $annonce->description_anno = $request->description_anno;
            $annonce->disponibilite_annonce = $request->disponibilite_annonce;
            $annonce->statut_anno = 'active';
            $annonce->date_publication_anno = now();
            $annonce->proprietaire_id = Auth::id();
            $annonce->save();

            return redirect()->route('proprietaire.annoncesproprietaire.index')->with('success', 'Annonce créée avec succès!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erreur lors de la création de l\'annonce: ' . $e->getMessage());
        }
    }
}
