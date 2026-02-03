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
        $reservations = Reservation::whereHas('logement', function($query) {
            $query->where('proprietaire_id', Auth::id());
        })->with('locataire', 'logement')->latest()->paginate(10);
        
        // Get statistics
        $totalReservations = Reservation::whereHas('logement', function($query) {
            $query->where('proprietaire_id', Auth::id());
        })->count();
        
        $pendingReservations = Reservation::whereHas('logement', function($query) {
            $query->where('proprietaire_id', Auth::id());
        })->where('statut_res', 'en_attente')->count();
        
        $confirmedReservations = Reservation::whereHas('logement', function($query) {
            $query->where('proprietaire_id', Auth::id());
        })->where('statut_res', 'confirmee')->count();
        
        return view('proprietaire.reservations.index', compact('reservations', 'totalReservations', 'pendingReservations', 'confirmedReservations'));
    }
}
