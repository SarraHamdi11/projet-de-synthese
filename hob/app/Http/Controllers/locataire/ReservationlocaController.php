<?php

namespace App\Http\Controllers\locataire;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationlocaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!in_array(auth()->user()->role_uti, ['locataire', 'colocataire'])) {
                return redirect()->route('visitor')->with('error', 'Accès non autorisé');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $reservations = Reservation::where('locataire_id', Auth::id())
            ->with('logement', 'proprietaire')
            ->latest()
            ->paginate(10);
        
        return view('locataire.reservations.index', compact('reservations'));
    }

    public function create($annonce_id)
    {
        $annonce = Annonce::findOrFail($annonce_id);
        return view('locataire.reservations.create', compact('annonce'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'annonce_id' => 'required|exists:annonces,id',
            'date_debut' => 'required|date|after:today',
            'date_fin' => 'required|date|after:date_debut',
            'message' => 'nullable|string|max:1000',
        ]);

        Reservation::create([
            'locataire_id' => Auth::id(),
            'annonces_id' => $request->annonce_id,
            'date_debut_res' => $request->date_debut,
            'date_fin_res' => $request->date_fin,
            'message_res' => $request->message,
            'statut_res' => 'en_attente',
            'date_creation_res' => now(),
        ]);

        return redirect()->route('locataire.reservations.index')->with('success', 'Réservation envoyée avec succès');
    }
}
