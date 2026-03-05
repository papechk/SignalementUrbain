<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('terrain_id')->constrained('terrains')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('client_nom');
            $table->string('client_email')->nullable();
            $table->string('client_telephone')->nullable();
            $table->dateTime('debut');
            $table->dateTime('fin');
            $table->enum('statut', ['en_attente', 'confirmee', 'annulee'])->default('en_attente');
            $table->decimal('montant_total', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['terrain_id', 'debut', 'fin']);
            $table->index('statut');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
