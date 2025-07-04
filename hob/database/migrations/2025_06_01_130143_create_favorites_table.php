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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('logement_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('utilisateurs')->onDelete('cascade');
            $table->foreign('logement_id')->references('id')->on('logements')->onDelete('cascade');
            $table->unique(['user_id', 'logement_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
