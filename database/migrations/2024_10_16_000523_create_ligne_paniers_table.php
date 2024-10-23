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
        Schema::create('ligne_paniers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('panier_id')->constrained()->onDelete('cascade'); // Lien vers le panier
            $table->foreignId('produit_id')->constrained()->onDelete('cascade'); // Lien vers le produit
            $table->integer('quantite');
            $table->double('prixTotal', 8, 2);
            $table->double('prixUnitaire', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ligne_paniers');
    }
};
