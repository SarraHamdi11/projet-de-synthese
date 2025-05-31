<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\Reservation;
use App\Models\Annonce;
use App\Models\Avis;
use App\Models\Favori;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\Utilisateur;
use App\Models\Statistique;
use App\Models\Administrateur;

use App\Models\Logement;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create some users and logements to associate them with the other tables
        $utilisateurs = Utilisateur::factory(10)->create();
        $logements = Logement::factory(5)->create();
         Administrateur::factory(1)->create();


        // Create Notifications with random user IDs
        Notification::factory(10)->create([
            'notifiable_id' => $utilisateurs->random()->id,
            'notifiable_type' => 'App\\Models\\Utilisateur',
        ]);

        // Create Reservations with random user and logement IDs
        Reservation::factory(10)->create([
            'locataire_id' => $utilisateurs->random()->id,
            'proprietaire_id' => $utilisateurs->random()->id,
            'logements_id' => $logements->random()->id,
        ]);

        // Create Annonces with random user and logement IDs
        Annonce::factory(10)->create([
            'logement_id' => $logements->random()->id,
            'proprietaire_id' => $utilisateurs->random()->id,
        ]);

        // Create Avis with random user and annonce IDs
        Avis::factory(10)->create([
            'annonce_id' => Annonce::inRandomOrder()->first()->id,
            'locataire_id' => $utilisateurs->random()->id,
        ]);

        // Create Favoris with random user and annonce IDs
        Favori::factory(10)->create([
            'locataire_id' => $utilisateurs->random()->id,
            'annonce_id' => Annonce::inRandomOrder()->first()->id,
        ]);
        Statistique::factory(1)->create([
            'nombre_utilisateur' => $utilisateurs->count(),
            'nombre_annonce' => 5, // You can adjust these numbers
            'note_moyenne_annonce' => 4.5,
            'nombre_reservation' => 10,
            'nombre_reservation_annule' => 2,
            'nombre_reservation_accepter' => 8,
            'nombre_reservation_en_attente' => 2,
            'note_moyenne_utilisateur' => 4.0,
        ]);
        $conversations = Conversation::factory(5)->create();

        // Create 3 messages for each conversation (no conversation_id field)
        $conversations->each(function (
            $conversation) {
            Message::factory(3)->create();
        });
    }
}
