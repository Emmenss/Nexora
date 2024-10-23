<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('publicites', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->string('title'); // Titre de la publicité
            $table->string('body'); // URL de l'image
            $table->string('contain'); // Contenu de la publicité
            $table->string('locations'); // Zone choisie
            $table->timestamps(); // Champs created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('publicites');
    }
};
