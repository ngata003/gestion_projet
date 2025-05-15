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
        Schema::create('taches_realisations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_realisation')->references('id')->on('realisations')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nom_tache');
            $table->string('description');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('status');
            $table->string('nom_gestionnaire');
            $table->string('nom_projet');

            $table->foreign('nom_tache')->references('nom_tache')->on('taches')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('nom_gestionnaire')->references('name')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('nom_projet')->references('nom_projet')->on('projets')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taches_realisations');
    }
};
