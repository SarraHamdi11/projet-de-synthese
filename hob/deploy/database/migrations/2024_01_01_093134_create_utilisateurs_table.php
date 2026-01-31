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
    {Schema::create('utilisateurs', function (Blueprint $table) {
        $table->id();
        $table->string('nom_uti');
        $table->string('prenom');
        $table->string('email_uti')->unique();
        $table->string('mot_de_passe_uti',300);
        $table->enum('role_uti', ['locataire', 'colocataire', 'proprietaire', 'admin']);
        $table->string('photodeprofil_uti')->nullable();
        $table->string('tel_uti');
        $table->date('date_inscription_uti');
    $table->string('ville');
        $table->date('date_naissance');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
