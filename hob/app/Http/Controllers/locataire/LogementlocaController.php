<?php

namespace App\Http\Controllers\locataire;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Logement; // Assuming a Logement model exists
use Carbon\Carbon;
use App\Models\Utilisateur;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class LogementlocaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get statistics for the dashboard
        $totalReservations = \App\Models\Reservation::where('locataire_id', $user->id)->count();
        $totalFavorites = \App\Models\Favorite::where('user_id', $user->id)->count();
        
        return view('locataire.accueillocataire', compact('totalReservations', 'totalFavorites'));
    }

    public function indexLocataire(Request $request)
    {
        $user = Auth::user();
        $realUserIds = Utilisateur::whereNotNull('email_uti')
            ->where('email_uti', '!=', '')
            ->whereNotNull('tel_uti')
            ->where('tel_uti', '!=', '')
            ->whereNotNull('prenom')
            ->where('prenom', '!=', '')
            ->whereNotNull('nom_uti')
            ->where('nom_uti', '!=', '')
            ->whereNotNull('date_naissance')
            ->pluck('id');

        $query = \App\Models\Logement::with(['proprietaire', 'favorites' => function($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
        ->whereIn('proprietaire_id', $realUserIds);

        // Search by city
        if ($request->filled('city')) {
            // Extract just the city name before any comma
            $cityName = explode(',', $request->city)[0];
            $query->where('ville', 'like', '%' . trim($cityName) . '%');
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('prix_log', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('prix_log', '<=', $request->max_price);
        }

        // Filter by search type (logement/colocation)
        if ($request->filled('search_type')) {
            $searchTypes = $request->search_type;
            
            $query->where(function($q) use ($searchTypes) {
                foreach ($searchTypes as $type) {
                    if ($type === 'logement') {
                        $q->orWhereHas('proprietaire', function($q) {
                            $q->where('type_uti', 'proprietaire');
                        });
                    } elseif ($type === 'colocation') {
                        $q->orWhereHas('proprietaire', function($q) {
                            $q->where('type_uti', 'locataire');
                        });
                    }
                }
            });
        }

        // Filter by property type
        if ($request->filled('logement_type')) {
            $query->whereIn('type_log', $request->logement_type);
        }

        // Filter by number of roommates
        if ($request->filled('colocataires')) {
            $query->where(function($q) use ($request) {
                foreach ($request->colocataires as $coloc) {
                    if ($coloc === 'Solo') {
                        $q->orWhere('nombre_colocataire_log', 1);
                    } elseif ($coloc === '2') {
                        $q->orWhere('nombre_colocataire_log', 2);
                    } elseif ($coloc === '3+') {
                        $q->orWhere('nombre_colocataire_log', '>=', 3);
                    }
                }
            });
        }

        $listings = $query->get()->map(function($listing) {
            $listing->is_favorited = $listing->favorites->isNotEmpty();
            return $listing;
        });

        return view('locataire.logementsloca', compact('listings'));
    }

    public function toggleFavorite(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Non authentifié'], 401);
        }
        $listing = Logement::find((int) $id);
        if (!$listing) {
            return response()->json(['error' => 'Logement non trouvé'], 404);
        }
        $favorite = Favorite::where('user_id', $user->id)->where('logement_id', $listing->id)->first();
        if ($favorite) {
            $favorite->delete();
            return response()->json(['success' => 'Retiré des favoris', 'is_favorited' => false]);
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'logement_id' => $listing->id,
            ]);
            return response()->json(['success' => 'Ajouté aux favoris', 'is_favorited' => true]);
        }
    }

    public function showFavorites(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à vos favoris.');
        }
        $favorites = Favorite::with('logement')->where('user_id', $user->id)->get();
        return view('locataire.favorites', compact('favorites'));
    }

    public function showReservation($id)
    {
        // Fetch listing from the database
        $listing = Logement::find((int) $id);

        if (!$listing) {
            return redirect()->route('logementsloca')->with('error', 'Logement non trouvé.');
        }

        return view('locataire.reservation', [
            'listing' => $listing
        ]);
    }

    public function storeReservation(Request $request)
    {
        $validatedData = $request->validate([
            'listing_id' => 'required|integer|exists:logements,id',
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'colocataires' => 'required|integer|min:1',
        ]);

        // Récupérer les réservations existantes de la session
        $reservations = session('reservations', []);

        // Ajouter la nouvelle réservation
        $reservations[] = [
            'id' => count($reservations) + 1,
            'listing_id' => $validatedData['listing_id'],
            'title' => $validatedData['title'],
            'type' => $validatedData['type'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'colocataires' => $validatedData['colocataires'],
            'created_at' => now()->format('Y-m-d')
        ];

        // Sauvegarder les réservations dans la session
        session(['reservations' => $reservations]);

        // Create a Reservation model for notification
        $logement = \App\Models\Logement::find($validatedData['listing_id']);
        if ($logement && $logement->proprietaire_id) {
            $proprietaire = \App\Models\Utilisateur::find($logement->proprietaire_id);
            if ($proprietaire) {
                $reservationModel = new \App\Models\Reservation([
                    'locataire_id' => auth()->id(),
                    'proprietaire_id' => $logement->proprietaire_id,
                    'logements_id' => $logement->id,
                    'date_debut_res' => $validatedData['start_date'],
                    'date_fin_res' => $validatedData['end_date'],
                    'statut_res' => 'en_attente',
                ]);
                $reservationModel->save();
                $proprietaire->notify(new \App\Notifications\ReservationCreatedNotification($reservationModel));
            }
        }

        return redirect()->route('logementsloca')->with('success', 'Votre réservation a été effectuée avec succès !');
    }

    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        $logement = Logement::findOrFail($id);
        $user = Auth::user();

        // Find the annonce for this logement
        $annonce = $logement->annonce;
        if ($annonce) {
            \App\Models\Avis::create([
                'contenu' => $request->comment,
                'note' => 5, // or get from form
                'annonce_id' => $annonce->id,
                'locataire_id' => $user->id,
            ]);
        }

        return redirect()->back()->with('success', 'Commentaire ajouté avec succès');
    }

    public function showDetails($id)
    {
        $logement = Logement::with(['proprietaire', 'annonce', 'annonce.avis', 'annonce.avis.locataire'])->findOrFail($id);
        $proprietaire = $logement->proprietaire;

        // Retrieve photos from the database
        $photos = [];
        if ($logement->photos) {
            $photos = is_array($logement->photos) ? $logement->photos : json_decode($logement->photos, true);
        }

        return view('locataire.details', compact('logement', 'proprietaire', 'photos'));
    }

    public function logementsloca()
    {
        return $this->indexLocataire(request());
    }
}