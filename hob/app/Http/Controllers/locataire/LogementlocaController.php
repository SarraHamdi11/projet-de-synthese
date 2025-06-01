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
    public function indexLocataire(Request $request)
    {
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
        $listings = \App\Models\Logement::with('proprietaire')
            ->whereIn('proprietaire_id', $realUserIds)
            ->paginate(9);
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
        $validatedData = $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        // Vérifier si l'utilisateur a déjà réservé ce logement (simplified logic)
        $reservations = session('reservations', []);
        $hasReserved = collect($reservations)->where('listing_id', (int) $id)->count() > 0;

        if (!$hasReserved) {
            return redirect()->back()->with('error', 'Vous n\'avez pas réservé ce logement.');
        }

        // Récupérer les commentaires existants de la session
        $comments = session('comments', []);

        // Ajouter le nouveau commentaire
        $comments[] = [
            'id' => count($comments) + 1,
            'listing_id' => (int) $id,
            'user' => 'Utilisateur',
            'comment' => $validatedData['comment'],
            'rating' => (int) $validatedData['rating'],
            'created_at' => now()->format('Y-m-d')
        ];

        // Sauvegarder les commentaires mis à jour dans la session
        session(['comments' => $comments]);

        return redirect()->back()->with('success', 'Votre commentaire a été ajouté avec succès !');
    }

    public function showDetails($id)
    {
        // Fetch listing from the database
        $logement = Logement::find((int) $id);

        if (!$logement) {
            abort(404, 'Logement non trouvé');
        }

        $proprietaire = $logement->proprietaire; // Eloquent relation

        return view('locataire.details', compact('logement', 'proprietaire'));
    }
}