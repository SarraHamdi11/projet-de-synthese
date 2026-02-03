<?php

namespace App\Http\Controllers\proprietaire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Logement;
use Illuminate\Support\Facades\Auth;
use App\Models\Utilisateur;

class LogementpropController extends Controller
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
    public function index(Request $request)
    {
        // Get only current user's properties
        $query = Logement::with(['proprietaire', 'annonce'])
            ->where('proprietaire_id', Auth::id());

        $perPage = 9;
        $page = $request->input('page', 1);
        $filteredListings = $query->paginate($perPage, ['*'], 'page', $page);
        $total = $filteredListings->total();

        // Get statistics for dashboard
        $totalProperties = Logement::where('proprietaire_id', Auth::id())->count();
        $totalReservations = \App\Models\Reservation::whereHas('logement', function($query) {
            $query->where('proprietaire_id', Auth::id());
        })->count();
        $activeAnnonces = \App\Models\Annonce::whereHas('logement', function($query) {
            $query->where('proprietaire_id', Auth::id());
        })->where('disponibilite_annonce', true)->count();

        return view('proprietaire.accueilproprietaire', compact('filteredListings', 'total', 'perPage', 'page', 'totalProperties', 'totalReservations', 'activeAnnonces'));
    }

    public function details($id)
    {
        $listing = Logement::with(['annonce', 'annonce.avis', 'annonce.avis.locataire'])->find($id);

        if (!$listing) {
            return redirect()->route('proprietaire.logements')->with('error', 'Logement non trouvé.');
        }

        return view('proprietaire.details', compact('listing'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'localisation' => 'required|string|max:255',
            'type' => 'required|string|in:appartement,maison,studio',
            'nombre_colocataire' => 'required|integer|min:1',
            'ville' => 'required|string|max:255',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'etage' => 'nullable|integer|min:0',
        ]);

        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('logements', 'public');
                $photos[] = $path;
            }
        }

        $logement = Logement::create([
            'titre_log' => $request->titre,
            'description_log' => $request->description ?? 'Description par défaut',
            'prix_log' => $request->prix,
            'localisation_log' => $request->localisation,
            'type_log' => $request->type,
            'nombre_colocataire_log' => $request->nombre_colocataire,
            'ville' => $request->ville,
            'photos' => $photos,
            'etage' => $request->etage,
            'proprietaire_id' => Auth::id(),
            'date_creation_log' => now(),
            'views' => 0,
            'equipements' => json_encode($request->equipements ?? []),
        ]);

        return redirect()->route('proprietaire.logements.index')
            ->with('success', 'Logement créé avec succès.');
    }

    public function logements()
    {
        $logements = Logement::with(['annonce', 'proprietaire'])
            ->where('proprietaire_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('proprietaire.logements', compact('logements'));
    }

    public function create()
    {
        return view('proprietaire.create');
    }

    public function edit($id)
    {
        $logement = Logement::findOrFail($id);
        
        // Check if the logement belongs to the current user
        if ($logement->proprietaire_id !== Auth::id()) {
            return redirect()->route('proprietaire.logements.index')->with('error', 'Accès non autorisé');
        }
        
        return view('proprietaire.edit', compact('logement'));
    }

    public function update(Request $request, $id)
    {
        $logement = Logement::findOrFail($id);
        
        // Check if the logement belongs to the current user
        if ($logement->proprietaire_id !== Auth::id()) {
            return redirect()->route('proprietaire.logements.index')->with('error', 'Accès non autorisé');
        }
        
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'localisation' => 'required|string|max:255',
            'type' => 'required|string|in:appartement,maison,studio',
            'nombre_colocataire' => 'required|integer|min:1',
            'ville' => 'required|string|max:255',
        ]);

        $logement->update([
            'titre_log' => $request->titre,
            'description_log' => $request->description,
            'prix_log' => $request->prix,
            'localisation_log' => $request->localisation,
            'type_log' => $request->type,
            'nombre_colocataire_log' => $request->nombre_colocataire,
            'ville' => $request->ville,
        ]);

        return redirect()->route('proprietaire.logements.index')
            ->with('success', 'Logement mis à jour avec succès.');
    }

    public function delete($id)
    {
        $logement = Logement::findOrFail($id);
        
        // Check if the logement belongs to the current user
        if ($logement->proprietaire_id !== Auth::id()) {
            return redirect()->route('proprietaire.logements.index')->with('error', 'Accès non autorisé');
        }
        
        $logement->delete();
        
        return redirect()->route('proprietaire.logements.index')
            ->with('success', 'Logement supprimé avec succès.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('proprietaire.myprofile', compact('user'));
    }

    public function messages()
    {
        $user = Auth::user();
        $conversations = \App\Models\Conversation::where(function($query) use ($user) {
            $query->where('expediteur_id', $user->id)
                  ->orWhere('destinataire_id', $user->id);
        })->with(['expediteur', 'destinataire', 'messages' => function($query) {
            $query->latest()->first();
        }])
        ->latest('date_debut_conv')
        ->get();
        
        return view('messages.index', compact('conversations'));
    }
}