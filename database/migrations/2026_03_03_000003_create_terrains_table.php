<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('terrains', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('slug')->unique();
            $table->enum('type', ['football', 'basketball', 'tennis', 'multi_sport', 'autre'])->default('multi_sport');
            $table->string('surface')->default('synthétique');
            $table->unsignedInteger('capacite')->nullable();
            $table->decimal('prix_heure', 10, 2)->default(0);
            $table->string('adresse');
            $table->string('ville')->nullable();
            $table->foreignId('proprietaire_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('description')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('terrains');
    }
};
