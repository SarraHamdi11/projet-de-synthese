<?php

namespace App\Http\Controllers\proprietaire;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Annonce;
use App\Models\Reservation;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Avis;

class AccueilProprietaireController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistiques principales
        $totalRequests = Reservation::where('proprietaire_id', $user->id)->count();
        $confirmedBookings = Reservation::where('proprietaire_id', $user->id)
            ->where('statut_res', 'confirmé')
            ->count();
        $unreadMessages = Message::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->count();

        // Logements populaires (12 derniers logements disponibles)
        $latestLogements = Annonce::with('logement')
            ->where('statut_anno', 'disponible')
            ->orderByDesc('date_publication_anno')
            ->take(12)
            ->get();

        // Témoignages (10 derniers avis)
        $avisClients = Avis::select('avis.*', 'utilisateurs.nom_uti', 'utilisateurs.prenom')
            ->join('utilisateurs', 'avis.locataire_id', '=', 'utilisateurs.id')
            ->latest('avis.id')
            ->take(10)
            ->get();

        return view('proprietaire.accueilproprietaire', compact(
            'user',
            'totalRequests',
            'confirmedBookings',
            'unreadMessages',
            'latestLogements',
            'avisClients'
        ));
    }
}
