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
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->string('titre_anno');
            $table->text('description_anno');
            $table->string('statut_anno')->default('disponible');
            $table->date('date_publication_anno');
            $table->foreignId('logement_id')->constrained('logements')->onDelete('cascade');
            $table->foreignId('proprietaire_id')->constrained('utilisateurs')->onDelete('cascade');
            //$table->foreignId('proprietaire_id')->nullable()->constrained('utilisateurs')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};