<?php

namespace App\Http\Controllers\Locataire;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationLocataireController extends Controller
{
    private function isLocataireOrColocataire()
    {
        return Auth::check() && in_array(Auth::user()->role_uti, ['locataire', 'colocataire']);
    }

    public function index(Request $request)
    {
        if (!$this->isLocataireOrColocataire()) {
            abort(403, 'Unauthorized action.');
        }

        $locataire = Auth::user();
        // Use 'statut' to match the view's form input
        $statut = $request->input('statut', 'en_attente');
        $statuses = ['en_attente', 'acceptee', 'annulee', 'terminee', 'historique'];

        if (!in_array($statut, $statuses)) {
            $statut = 'en_attente';
        }

        $query = Reservation::where('locataire_id', $locataire->id)
            ->with(['logements.annonces', 'proprietaire']);

        // Handle filtering by statut
        if ($statut === 'historique') {
            $query->where('statut_res', 'terminee');
        } else {
            $query->where('statut_res', $statut);
        }

        $reservations = $query->orderBy('created_at', 'desc')->get();

        $today = Carbon::today();
        foreach ($reservations as $reservation) {
            if ($reservation->date_debut_res && $reservation->date_fin_res) {
                $startDate = Carbon::parse($reservation->date_debut_res);
                $endDate = Carbon::parse($reservation->date_fin_res);

                // Auto-terminate accepted reservations that have ended
                if ($reservation->statut_res === 'acceptee' && $today->gt($endDate)) {
                    $reservation->update(['statut_res' => 'terminee']);
                    // Notification::create([
                    //     'contenu_noti' => "La réservation #{$reservation->id} a été terminée car la période est terminée.",
                    //     'type' => 'reservation',
                    //     'date_noti' => now(),
                    //     'utilisateur_id' => $reservation->locataire_id,
                    // ]);
                }

                $reservation->duration = $startDate->diffInDays($endDate);
                $reservation->remaining_days = ($reservation->statut_res === 'acceptee' && $today->lte($endDate))
                    ? $today->diffInDays($endDate)
                    : null;
            } else {
                $reservation->duration = null;
                $reservation->remaining_days = null;
            }
        }

        // Statistics
        $totalReservations = Reservation::where('locataire_id', $locataire->id)->count();
        $enAttente = Reservation::where('locataire_id', $locataire->id)->where('statut_res', 'en_attente')->count();
        $acceptees = Reservation::where('locataire_id', $locataire->id)->where('statut_res', 'acceptee')->count();
        $annulees = Reservation::where('locataire_id', $locataire->id)->where('statut_res', 'annulee')->count();
        $terminees = Reservation::where('locataire_id', $locataire->id)->where('statut_res', 'terminee')->count();

        return view('locataire.reservations.index', compact(
            'reservations',
            'totalReservations',
            'enAttente',
            'acceptees',
            'annulees',
            'terminees',
            'statut' // Pass statut instead of status
        ));
    }

    public function show($id)
    {
        if (!$this->isLocataireOrColocataire()) {
            abort(403, 'Unauthorized action.');
        }

        $reservation = Reservation::where('locataire_id', Auth::user()->id)
            ->with(['logements.annonces', 'proprietaire'])
            ->findOrFail($id);

        return view('locataire.reservations.show', compact('reservation'));
    }

    public function edit($id)
    {
        if (!$this->isLocataireOrColocataire()) {
            abort(403, 'Unauthorized action.');
        }

        $reservation = Reservation::where('locataire_id', Auth::user()->id)
            ->where('statut_res', 'en_attente')
            ->with(['logements'])
            ->findOrFail($id);

        return view('locataire.reservations.edit', compact('reservation'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->isLocataireOrColocataire()) {
            abort(403, 'Unauthorized action.');
        }

        $reservation = Reservation::where('locataire_id', Auth::user()->id)
            ->where('statut_res', 'en_attente')
            ->findOrFail($id);

        $validated = $request->validate([
            'nombre_colocataire_log' => 'required|integer|min:1',
            'date_debut_res' => 'required|date|after:today',
            'date_fin_res' => 'required|date|after:date_debut_res',
        ]);

        $reservation->logements->update([
            'nombre_colocataire_log' => $validated['nombre_colocataire_log'],
        ]);

        $reservation->update([
            'date_debut_res' => $validated['date_debut_res'],
            'date_fin_res' => $validated['date_fin_res'],
        ]);

        // Notification::create([
        //     'contenu_noti' => "La réservation #{$reservation->id} a été modifiée par le locataire.",
        //     'type' => 'reservation',
        //     'date_noti' => now(),
        //     'utilisateur_id' => $reservation->proprietaire_id,
        // ]);

        return redirect()->route('locataire.reservations.index')->with('success', 'Réservation modifiée avec succès.');
    }

    public function annuler(Request $request, $id)
    {
        if (!$this->isLocataireOrColocataire()) {
            abort(403, 'Unauthorized action.');
        }

        $reservation = Reservation::where('locataire_id', Auth::user()->id)
            ->where('statut_res', 'en_attente')
            ->findOrFail($id);

        $reservation->update(['statut_res' => 'annulee']); // Fixed typo: status_res to statut_res

        // Notification::create([
        //     'contenu_noti' => "La réservation #{$reservation->id} a été annulée par le locataire.",
        //     'type' => 'reservation',
        //     'date_noti' => now(),
        //     'utilisateur_id' => $reservation->proprietaire_id,
        // ]);

        return redirect()->route('locataire.reservations.index')->with('success', 'Réservation annulée avec succès.');
    }

    public function historique(Request $request)
    {
        if (!$this->isLocataireOrColocataire()) {
            abort(403, 'Unauthorized action.');
        }

        $request->merge(['statut' => 'historique']); // Use statut to match view
        return $this->index($request);
    }
}