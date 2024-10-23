<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('boutiques', function (Blueprint $table) {
            $table->id();
            $table->string('imgshop');
            $table->string('nameshop');
            $table->string('addresshop');
            $table->string('phoneshop');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Liaison avec le modèle User
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('boutiques');
    }
};
