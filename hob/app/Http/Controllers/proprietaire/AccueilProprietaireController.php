<?php

namespace App\Http\Controllers\proprietaire;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Annonce;
use App\Models\Reservation;
use App\Models\Conversation;

class AccueilProprietaireController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Get the currently authenticated user

        // Total number of reservation requests (without proprietaire_id)
        $totalRequests = Reservation::whereNull('proprietaire_id')->count();

        // Count of confirmed bookings
        $confirmedBookings = Reservation::whereNull('proprietaire_id')
            ->where('statut_res', 'confirmé')
            ->count();

        // Count of rejected bookings
        $rejectedBookings = Reservation::whereNull('proprietaire_id')
            ->where('statut_res', 'refusé')
            ->count();

        // Latest available logements (annonces)
        $latestLogements = Annonce::whereNull('proprietaire_id')
            ->where('statut_anno', 'disponible')
            ->orderByDesc('date_publication_anno')
            ->take(8)
            ->get();

        // Get all conversations where user is involved
        $conversations = Conversation::where('expediteur_id', $user->id)
            ->orWhere('destinataire_id', $user->id)
            ->get();

        // Unread message count for the authenticated user (as receiver)
        $unreadMessages = $user->receivedMessages()->where('is_read', false)->count();

        // Sample statistics
        $stats = [
            ['label' => 'Appartements', 'value' => Annonce::count()],
            ['label' => 'Utilisateurs actifs', 'value' => 300], // placeholder
            ['label' => 'Réservations', 'value' => Reservation::count()],
            ['label' => 'Messages échangés', 'value' => $conversations->count()],
        ];

        return view('proprietaire.accueilproprietaire', compact(
            'user',
            'totalRequests',
            'confirmedBookings',
            'rejectedBookings',
            'latestLogements',
            'stats',
            'unreadMessages'
        ));
    }
}
