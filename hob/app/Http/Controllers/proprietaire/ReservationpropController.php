<?php

namespace App\Http\Controllers\proprietaire;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationpropController extends Controller
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
        $user = Auth::user();
        
        // Get reservations for the owner's properties
        $reservations = Reservation::whereHas('logement', function($query) {
            $query->where('proprietaire_id', Auth::id());
        })->with('locataire', 'logement')->latest()->paginate(10);
        
        // Get statistics
        $totalDemandes = Reservation::whereHas('logement', function($query) {
            $query->where('proprietaire_id', Auth::id());
        })->count();
        
        $enAttente = Reservation::whereHas('logement', function($query) {
            $query->where('proprietaire_id', Auth::id());
        })->where('statut_res', 'en_attente')->count();
        
        $acceptees = Reservation::whereHas('logement', function($query) {
            $query->where('proprietaire_id', Auth::id());
        })->where('statut_res', 'acceptee')->count();
        
        $annulees = Reservation::whereHas('logement', function($query) {
            $query->where('proprietaire_id', Auth::id());
        })->where('statut_res', 'annulee')->count();
        
        $terminees = Reservation::whereHas('logement', function($query) {
            $query->where('proprietaire_id', Auth::id());
        })->where('statut_res', 'terminee')->count();
        
        // Get owner's properties for filter
        $logements = \App\Models\Logement::where('proprietaire_id', Auth::id())->get();
        
        return view('proprietaire.reservations.index', compact('reservations', 'totalDemandes', 'enAttente', 'acceptees', 'annulees', 'terminees', 'logements'));
    }
}
