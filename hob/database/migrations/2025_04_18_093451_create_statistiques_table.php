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
        Schema::create('statistiques', function (Blueprint $table) {
            $table->id('id_stati');
            $table->unsignedInteger('nombre_utilisateur')->default(0);
            $table->unsignedInteger('nombre_annonce')->default(0);
            $table->float('note_moyenne_annonce')->nullable();
            $table->unsignedInteger('nombre_reservation')->default(0);
            $table->unsignedInteger('nombre_reservation_annule')->default(0);
            $table->unsignedInteger('nombre_reservation_accepter')->default(0);
            $table->unsignedInteger('nombre_reservation_en_attente')->default(0);
            $table->float('note_moyenne_utilisateur')->nullable();
              $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistiques');
    }
};
