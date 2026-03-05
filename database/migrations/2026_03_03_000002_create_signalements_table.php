<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('signalements', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('titre');
            $table->text('description');
            $table->foreignId('categorie_id')->constrained('categories')->onDelete('cascade');
            $table->string('adresse');
            $table->string('quartier')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('statut', ['nouveau', 'en_cours', 'resolu', 'rejete'])->default('nouveau');
            $table->enum('priorite', ['faible', 'moyenne', 'haute', 'urgente'])->default('moyenne');
            $table->string('photo')->nullable();
            $table->string('signale_par');
            $table->string('email_signaleur')->nullable();
            $table->string('telephone_signaleur')->nullable();
            $table->text('commentaire_mairie')->nullable();
            $table->timestamp('date_resolution')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signalements');
    }
};
