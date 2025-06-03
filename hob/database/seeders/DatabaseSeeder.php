<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    Notification,
    Reservation,
    Annonce,
    Avis,
    Favori,
    Message,
    Conversation,
    Utilisateur,
    Statistique,
    Administrateur,
    Logement
};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer 50 utilisateurs
        $utilisateurs = Utilisateur::factory(50)->create();

        // Créer 25 logements
        $logements = Logement::factory(25)->create();

        // Créer 30 annonces avec des logements et propriétaires aléatoires
        $annonces = Annonce::factory(30)->create([
            'logement_id' => $logements->random()->id,
            'proprietaire_id' => $utilisateurs->random()->id,
        ]);

        // 2 réservations pour chaque logement
        foreach ($logements as $logement) {
            Reservation::factory(2)->create([
                'logements_id' => $logement->id,
                'locataire_id' => $utilisateurs->random()->id,
                'proprietaire_id' => $utilisateurs->random()->id,
            ]);
        }

        // 5 avis pour chaque logement (liés à des annonces de ce logement)
        foreach ($logements as $logement) {
            $annonce = $annonces->firstWhere('logement_id', $logement->id);
            if ($annonce) {
                Avis::factory(5)->create([
                    'annonce_id' => $annonce->id,
                    'locataire_id' => $utilisateurs->random()->id,
                ]);
            }
        }

        // Créer des conversations basées sur les réservations
        foreach ($logements as $logement) {
            $proprietaire = $utilisateurs->random();
            $locataire = $utilisateurs->random();
            
            // Créer une conversation entre le propriétaire et le locataire
            $conversation = Conversation::factory()->create([
                'expediteur_id' => $proprietaire->id,
                'destinataire_id' => $locataire->id,
                'date_debut_conv' => now()->subDays(rand(1, 30))
            ]);

            // Créer une réservation associée
            Reservation::factory()->create([
                'logements_id' => $logement->id,
                'locataire_id' => $locataire->id,
                'proprietaire_id' => $proprietaire->id,
                'date_debut_res' => now()->addDays(rand(1, 30)),
                'date_fin_res' => now()->addDays(rand(31, 60)),
                'statut_res' => 'en_attente'
            ]);
        }

        // Créer un administrateur
        Administrateur::factory(1)->create();

        // Calculer dynamiquement les statistiques
        Statistique::factory(1)->create([
            'nombre_utilisateur' => Utilisateur::count(),
            'nombre_annonce' => Annonce::count(),
            'note_moyenne_annonce' => round(Avis::avg('note'), 2) ?? 0,
            'nombre_reservation' => Reservation::count(),
            'nombre_reservation_annule' => Reservation::where('statut_res', 'annulée')->count(),
            'nombre_reservation_accepter' => Reservation::where('statut_res', 'acceptée')->count(),
            'nombre_reservation_en_attente' => Reservation::where('statut_res', 'en_attente')->count(),
            'note_moyenne_utilisateur' => round(Avis::avg('note'), 2) ?? 0,
        ]);
    }
}
