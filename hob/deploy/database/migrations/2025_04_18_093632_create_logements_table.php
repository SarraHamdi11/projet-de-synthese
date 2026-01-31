<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logements', function (Blueprint $table) {
            $table->id(); // Id unique pour chaque logement
            $table->float('prix_log'); // Prix du logement
            $table->string('localisation_log'); // Localisation géographique du logement
            $table->date('date_creation_log'); // Date de création du logement
            $table->enum('type_log', ['studio', 'appartement', 'maison']); // Type de logement (choix entre studio, appartement, maison)
            $table->json('equipements')->nullable(); // Equipements du logement stockés au format JSON
            $table->json('photos')->nullable(); // Photos du logement stockées au format JSON
            $table->integer('etage')->nullable(); // Etage de l'immeuble (nullable si non applicable)
            $table->integer('nombre_colocataire_log')->default(1);
            $table->string('ville'); // Ville dans laquelle se trouve le logement
            $table->integer('views')->default(0); // Nombre de vues du logement
            $table->unsignedBigInteger('proprietaire_id')->nullable(); // Foreign key to link logement to proprietaire
            $table->foreign('proprietaire_id')->references('id')->on('utilisateurs')->onDelete('set null');
            $table->timestamps(); // Colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logements'); // Supprime la table 'logements' si elle existe
    }
};
