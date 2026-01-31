<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Utilisateur;
use App\Models\Logement;
use App\Models\Annonce;
use App\Models\Reservation;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Créer un utilisateur propriétaire
        $proprietaire = Utilisateur::factory()->create([
            'role_uti' => 'proprietaire',
            'email_uti' => 'proprio@example.com',
            'mot_de_passe_uti' => bcrypt('proprio123'),
            'nom_uti' => 'Martin',
            'prenom' => 'Sophie',
            'tel_uti' => '+33687654321',
            'ville' => 'Paris',
        ]);

        // Créer un utilisateur locataire pour les tests
        $locataireTest = Utilisateur::factory()->create([
            'role_uti' => 'locataire',
            'email_uti' => 'locataire@example.com',
            'mot_de_passe_uti' => bcrypt('locataire123'),
            'nom_uti' => 'Dupont',
            'prenom' => 'Jean',
            'tel_uti' => '+33612345678',
            'ville' => 'Paris',
        ]);

        // Créer 20 logements liés au propriétaire
        $logements = Logement::factory()->count(20)->create([
            'proprietaire_id' => $proprietaire->id,
        ]);

        // Créer des annonces pour chaque logement
        foreach ($logements as $logement) {
            Annonce::factory()->create([
                'logement_id' => $logement->id,
                'proprietaire_id' => $proprietaire->id,
                'titre_anno' => 'Appartement Haut Standing - ' . $logement->ville,
            ]);
        }

        // Créer 40 autres locataires
        $locataires = Utilisateur::factory()->count(40)->create([
            'role_uti' => 'locataire',
        ]);

        // Ajouter le locataire de test à la collection
        $locataires->push($locataireTest);

        // Créer des réservations spécifiques pour le locataire de test
        $logementsRandom = $logements->shuffle();

        // Réservation 1: En attente
        Reservation::create([
            'locataire_id' => $locataireTest->id,
            'proprietaire_id' => $proprietaire->id,
            'logements_id' => $logementsRandom[0]->id,
            'date_debut_res' => Carbon::today()->addDays(10), // 2025-06-11
            'date_fin_res' => Carbon::today()->addDays(40),   // 2025-07-11
            'statut_res' => 'en_attente',
            'created_at' => Carbon::today()->subDays(2),
        ]);

        // Réservation 2: Acceptée (en cours)
        Reservation::create([
            'locataire_id' => $locataireTest->id,
            'proprietaire_id' => $proprietaire->id,
            'logements_id' => $logementsRandom[1]->id,
            'date_debut_res' => Carbon::today()->subDays(5), // 2025-05-27
            'date_fin_res' => Carbon::today()->addDays(25),  // 2025-06-26
            'statut_res' => 'acceptee',
            'created_at' => Carbon::today()->subDays(7),
        ]);

        // Réservation 3: Refusée
        Reservation::create([
            'locataire_id' => $locataireTest->id,
            'proprietaire_id' => $proprietaire->id,
            'logements_id' => $logementsRandom[2]->id,
            'date_debut_res' => Carbon::today()->addDays(5), // 2025-06-06
            'date_fin_res' => Carbon::today()->addDays(35),  // 2025-07-06
            'statut_res' => 'annulee',
            'created_at' => Carbon::today()->subDays(10),
        ]);

        // Réservation 4: Terminée
        Reservation::create([
            'locataire_id' => $locataireTest->id,
            'proprietaire_id' => $proprietaire->id,
            'logements_id' => $logementsRandom[3]->id,
            'date_debut_res' => Carbon::today()->subDays(60), // 2025-04-02
            'date_fin_res' => Carbon::today()->subDays(30),   // 2025-05-02
            'statut_res' => 'terminee',
            'created_at' => Carbon::today()->subDays(65),
        ]);

        // Réservation 5: En attente, overlaps with Réservation 2
        Reservation::create([
            'locataire_id' => $locataireTest->id,
            'proprietaire_id' => $proprietaire->id,
            'logements_id' => $logementsRandom[1]->id,
            'date_debut_res' => Carbon::today()->subDays(2), // 2025-05-30
            'date_fin_res' => Carbon::today()->addDays(10),  // 2025-06-11
            'statut_res' => 'en_attente',
            'created_at' => Carbon::today()->subDays(3),
        ]);

        // Additional random reservations for the test locataire
        for ($i = 0; $i < 10; $i++) {
            $logement = $logementsRandom[$i % $logements->count()];
            Reservation::factory()->create([
                'locataire_id' => $locataireTest->id,
                'proprietaire_id' => $proprietaire->id,
                'logements_id' => $logement->id,
                'date_debut_res' => Carbon::today()->subDays(rand(60, 120)),
                'date_fin_res' => Carbon::today()->subDays(rand(30, 60)),
                'statut_res' => ['en_attente', 'acceptee', 'annulee', 'terminee'][rand(0, 3)],
                'created_at' => Carbon::today()->subDays(rand(65, 130)),
            ]);
        }

        // Optional: Create reservations for other locataires to populate the database
        foreach ($locataires as $locataire) {
            if ($locataire->id !== $locataireTest->id) {
                $randomLogement = $logementsRandom[rand(0, $logements->count() - 1)];
                Reservation::factory()->create([
                    'locataire_id' => $locataire->id,
                    'proprietaire_id' => $proprietaire->id,
                    'logements_id' => $randomLogement->id,
                    'date_debut_res' => Carbon::today()->subDays(rand(30, 60)),
                    'date_fin_res' => Carbon::today()->subDays(rand(1, 30)),
                    'statut_res' => ['en_attente', 'acceptee', 'annulee', 'terminee'][rand(0, 3)],
                    'created_at' => Carbon::today()->subDays(rand(35, 70)),
                ]);
            }
        }
    }
}