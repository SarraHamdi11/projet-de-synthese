<?php

namespace App\Http\Controllers\proprietaire;

use Carbon\Carbon;
use App\Models\Logement;
use App\Models\Reservation;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class ReservationProprietaireController extends Controller
{
    public function index(Request $request)
    {
        $proprietaire = Auth::user();

        // Récupérer tous les logements du propriétaire pour le filtre
        $logements = Logement::where('proprietaire_id', $proprietaire->id)
            ->with('annonces')
            ->get();

        // Construction de la requête des réservations
        $query = Reservation::whereHas('logements', function ($q) use ($proprietaire) {
            $q->where('proprietaire_id', $proprietaire->id);
        })->with(['locataire', 'logements.annonces']);

        // Filtrage par statut
        $statut = $request->get('statut', 'en_attente');
        switch ($statut) {
            case 'en_attente':
            case 'demande': // Handle both for compatibility
                $query->where('statut_res', 'en_attente');
                $statut = 'en_attente'; // Normalize for view
                break;
            case 'accepter':
            case 'acceptee': // Handle both for compatibility
                $query->where('statut_res', 'acceptee');
                $statut = 'acceptee'; // Normalize for view
                break;
            case 'refuser':
            case 'annulee': // Handle both for compatibility
                $query->where('statut_res', 'annulee');
                $statut = 'annulee'; // Normalize for view
                break;
            case 'historique':
            case 'terminee': // Handle both for compatibility
                $query->where('statut_res', 'terminee');
                $statut = 'terminee'; // Normalize for view
                break;
            default:
                $query->where('statut_res', 'en_attente');
                $statut = 'en_attente';
        }

        // Filtrage par logement
        if ($request->get('logement') && $request->get('logement') !== 'all') {
            $query->where('logements_id', $request->get('logement')); // Use logement_id instead of logements_id
        }

        $reservations = $query->orderBy('created_at', 'desc')->get();

        // Check and update reservations
        $today = Carbon::today();
        foreach ($reservations as $reservation) {
            if (isset($reservation->date_debut_res) && isset($reservation->date_fin_res)) {
                $start = Carbon::parse($reservation->date_debut_res);
                $end = Carbon::parse($reservation->date_fin_res);
                $duration = $start->diffInDays($end); // Fixed: Use start->diffInDays($end)

                // Check if reservation has ended and auto-terminate
                if ($reservation->statut_res === 'acceptee' && $today->greaterThanOrEqualTo($end)) {
                    $reservation->update(['statut_res' => 'terminee']);
                    // Notification::create([
                    //     'contenu_noti' => "La réservation #{$reservation->id} a été terminée automatiquement car la période est terminée.",
                    //     'type' => 'reservation',
                    //     'date_noti' => now(),
                    //     'utilisateur_id' => $reservation->locataire_id,
                    //     'reservation_id' => $reservation->id,
                    // ]);
                }

                // Attach duration and remaining days to reservation object for view
                $reservation->duration = $duration > 0 ? $duration : null;
                $reservation->remaining_days = $reservation->statut_res === 'acceptee' && $today->lessThan($end) ? $today->diffInDays($end) : 0;
            } else {
                $reservation->duration = null;
                $reservation->remaining_days = null;
            }
        }

        // Statistiques pour les cartes en haut
        $totalDemandes = Reservation::whereHas('logements', function ($q) use ($proprietaire) {
            $q->where('proprietaire_id', $proprietaire->id);
        })->count();
        $enAttente = Reservation::whereHas('logements', function ($q) use ($proprietaire) {
            $q->where('proprietaire_id', $proprietaire->id);
        })->where('statut_res', 'en_attente')->count();
        $acceptees = Reservation::whereHas('logements', function ($q) use ($proprietaire) {
            $q->where('proprietaire_id', $proprietaire->id);
        })->where('statut_res', 'acceptee')->count();
        $terminees = Reservation::whereHas('logements', function ($q) use ($proprietaire) {
            $q->where('proprietaire_id', $proprietaire->id);
        })->where('statut_res', 'terminee')->count();
        $annulees = Reservation::whereHas('logements', function ($q) use ($proprietaire) {
            $q->where('proprietaire_id', $proprietaire->id);
        })->where('statut_res', 'annulee')->count();

        // Group accepted reservations by day
        $acceptedByDay = [];
        if (Schema::hasColumn('reservations', 'date_debut_res')) {
            $acceptedByDay = Reservation::whereHas('logements', function ($q) use ($proprietaire) {
                $q->where('proprietaire_id', $proprietaire->id);
            })
                ->where('statut_res', 'acceptee')
                ->selectRaw('DATE(date_debut_res) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->get()
                ->map(function ($item) {
                    $item->date = Carbon::parse($item->date); // Convert string to Carbon
                    return $item;
                });
        }

        return view('proprietaire.reservations.index', compact(
            'reservations',
            'logements',
            'totalDemandes',
            'enAttente',
            'acceptees',
            'terminees',
            'annulees',
            'acceptedByDay',
            'statut'
        ));
    }

public function accepter($id)
{
    $reservation = Reservation::whereHas('logements', function ($q) {
        $q->where('proprietaire_id', Auth::id());
    })->findOrFail($id);

    // Check for overlapping reservations for the same logement
    $overlappingReservations = Reservation::where('logements_id', $reservation->logements_id)
        ->where('id', '!=', $reservation->id)
        ->where('statut_res', 'acceptee')
        ->where(function ($query) use ($reservation) {
            $query->whereBetween('date_debut_res', [$reservation->date_debut_res, $reservation->date_fin_res])
                  ->orWhereBetween('date_fin_res', [$reservation->date_debut_res, $reservation->date_fin_res])
                  ->orWhere(function ($q) use ($reservation) {
                      $q->where('date_debut_res', '<=', $reservation->date_debut_res)
                        ->where('date_fin_res', '>=', $reservation->date_fin_res);
                  });
        })
        ->get();

    // Refuse overlapping reservations
    foreach ($overlappingReservations as $otherReservation) {
        $otherReservation->update(['statut_res' => 'annulee']);
        // Notification::create([
        //     'contenu_noti' => "Votre réservation #{$otherReservation->id} a été annulée car une autre réservation a été acceptée pour le même logement.",
        //     'type' => 'reservation',
        //     'date_noti' => now(),
        //     'utilisateur_id' => $otherReservation->locataire_id,
        //     'reservation_id' => $otherReservation->id,
        // ]);
    }

    // Accept the current reservation
    $reservation->update(['statut_res' => 'acceptee']);

    // Create notification for acceptance
    // Notification::create([
    //     'contenu_noti' => "Votre réservation #{$reservation->id} a été acceptée par le propriétaire.",
    //     'type' => 'reservation',
    //     'date_noti' => now(),
    //     'utilisateur_id' => $reservation->locataire_id,
    //     'reservation_id' => $reservation->id,
    // ]);

    return redirect()->route('proprietaire.reservations.index')->with('success', 'Réservation acceptée avec succès');
}

    public function refuser($id)
    {
        $reservation = Reservation::whereHas('logements', function ($q) {
            $q->where('proprietaire_id', Auth::id());
        })->findOrFail($id);

        $reservation->update(['statut_res' => 'annulee']);

        // Notification::create([
        //     'contenu_noti' => "Votre réservation #{$reservation->id} a été refusée par le propriétaire.",
        //     'type' => 'reservation',
        //     'date_noti' => now(),
        //     'utilisateur_id' => $reservation->locataire_id,
        //     'reservation_id' => $reservation->id,
        // ]);

        return redirect()->route('proprietaire.reservations.index')->with('success', 'Réservation refusée');
    }

    public function historique()
    {
        $proprietaire = Auth::user();

        $reservations = Reservation::whereHas('logements', function ($q) use ($proprietaire) {
            $q->where('proprietaire_id', $proprietaire->id);
        })
            ->whereIn('statut_res', ['acceptee', 'terminee', 'annulee'])
            ->with(['locataire', 'logements.annonces'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('proprietaire.reservations.historique', compact('reservations'));
    }
}