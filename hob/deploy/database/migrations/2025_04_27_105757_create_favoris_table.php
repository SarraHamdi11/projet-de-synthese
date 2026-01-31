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
    {Schema::create('favoris', function (Blueprint $table) {
        $table->id();
        $table->foreignId('locataire_id')->constrained('utilisateurs')->onDelete('cascade');  // Clé étrangère vers utilisateurs (locataire ou colocataire)
        $table->foreignId('annonce_id')->constrained('annonces')->onDelete('cascade');  // Clé étrangère vers annonces
        $table->date('date_d_ajout_fav');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoris');
    }
};