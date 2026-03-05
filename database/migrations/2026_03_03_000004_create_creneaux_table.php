<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creneaux', function (Blueprint $table) {
            $table->id();
            $table->foreignId('terrain_id')->constrained('terrains')->cascadeOnDelete();
            $table->string('titre')->nullable();
            $table->dateTime('debut');
            $table->dateTime('fin');
            $table->enum('statut', ['disponible', 'bloque', 'reserve'])->default('disponible');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['terrain_id', 'debut', 'fin']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creneaux');
    }
};
