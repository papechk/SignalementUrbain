<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->unique()->constrained('reservations')->cascadeOnDelete();
            $table->string('reference')->unique();
            $table->decimal('montant', 10, 2);
            $table->enum('mode_paiement', ['carte', 'especes', 'virement', 'mobile_money', 'autre'])->default('autre');
            $table->enum('statut', ['en_attente', 'partiel', 'paye', 'rembourse', 'echec'])->default('en_attente');
            $table->dateTime('date_paiement')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('statut');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
