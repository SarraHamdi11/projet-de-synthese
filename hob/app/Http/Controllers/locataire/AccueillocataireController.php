<?php
namespace App\Http\Controllers\locataire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Avis;
use App\Models\Utilisateur;
use App\Models\Annonce;

class AccueilLocataireController extends Controller
{
    public function index()
    {
        $unreadCount = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();

        // Récupérer les 10 derniers avis
        $avisClients = Avis::select('avis.*', 'utilisateurs.nom_uti', 'utilisateurs.prenom')
            ->join('utilisateurs', 'avis.locataire_id', '=', 'utilisateurs.id')
            ->latest()
            ->take(10)
            ->get();

        // Récupérer les 12 derniers logements (annonces actives) pour le slider d'accueil
        $latestLogements = Annonce::select('annonces.*', 'logements.prix_log', 'logements.localisation_log', 'logements.photos')
            ->join('logements', 'annonces.logement_id', '=', 'logements.id')
            ->where('annonces.statut_anno', 'active')
            ->latest('annonces.date_publication_anno')
            ->take(12)
            ->get();

        // Fetch the 8 latest annonces (with logement)
        $latestAnnonces = Annonce::with('logement')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('locataire.accueillocataire', compact('unreadCount', 'avisClients', 'latestLogements', 'latestAnnonces'));
    }
}
