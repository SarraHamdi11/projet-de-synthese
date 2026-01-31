<?php

namespace App\Http\Controllers\Proprietaire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Logement;
use Illuminate\Support\Facades\Auth;
use App\Models\Utilisateur;

class LogementpropController extends Controller
{
    public function index(Request $request)
    {
        $realUserIds = Utilisateur::whereIn('role_uti', ['proprietaire', 'locataire'])
            ->whereNotNull('email_uti')
            ->where('email_uti', '!=', '')
            ->whereNotNull('tel_uti')
            ->where('tel_uti', '!=', '')
            ->whereNotNull('prenom')
            ->where('prenom', '!=', '')
            ->whereNotNull('nom_uti')
            ->where('nom_uti', '!=', '')
            ->whereNotNull('date_naissance')
            ->pluck('id');
        $query = \App\Models\Logement::with('proprietaire')
            ->whereIn('proprietaire_id', $realUserIds);

        $perPage = 9;
        $page = $request->input('page', 1);
        $filteredListings = $query->paginate($perPage, ['*'], 'page', $page);
        $total = $filteredListings->total();

        return view('proprietaire.logements', compact('filteredListings', 'total', 'perPage', 'page'));
    }

    public function details($id)
    {
        $listing = Logement::find($id);

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
}