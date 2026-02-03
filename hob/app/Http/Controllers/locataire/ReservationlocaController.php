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
        $user = Auth::user();
        
        // Get current filter status from request
        $statut = request('statut', 'all');
        
        // Get statistics for the dashboard
        $totalReservations = \App\Models\Reservation::where('locataire_id', $user->id)->count();
        $totalFavorites = \App\Models\Favorite::where('user_id', $user->id)->count();
        $totalMessages = \App\Models\Message::where(function($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
        })->count();
        
        // Get accepted reservations count
        $acceptees = \App\Models\Reservation::where('locataire_id', $user->id)
            ->where('statut_reservation', 'acceptee')
            ->count();
        
        // Get pending reservations count  
        $enAttente = \App\Models\Reservation::where('locataire_id', $user->id)
            ->where('statut_reservation', 'en_attente')
            ->count();
        
        // Get cancelled reservations count
        $annulees = \App\Models\Reservation::where('locataire_id', $user->id)
            ->where('statut_reservation', 'annulee')
            ->count();
        
        // Get completed reservations count
        $terminees = \App\Models\Reservation::where('locataire_id', $user->id)
            ->where('statut_reservation', 'terminee')
            ->count();
        
        // Build reservations query with filter
        $reservationsQuery = Reservation::where('locataire_id', Auth::id())
            ->with('logement', 'proprietaire');
            
        // Apply status filter if not 'all'
        if ($statut !== 'all') {
            $reservationsQuery->where('statut_reservation', $statut);
        }
        
        $reservations = $reservationsQuery->latest()->paginate(10);
        
        return view('locataire.reservations.index', compact('reservations', 'totalReservations', 'totalFavorites', 'totalMessages', 'acceptees', 'enAttente', 'annulees', 'terminees', 'statut'));
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
