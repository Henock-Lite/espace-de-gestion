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
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('fournisseur_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('numero_lot');

            $table->date('date_fabrication')->nullable();
            $table->date('date_expiration');

            $table->integer('quantite_initiale');
            $table->integer('quantite_restante');

            $table->decimal('prix_achat', 10, 2);

            $table->boolean('actif')->default(true);
            $table->boolean('is_perime')->default(false);
            $table->index(['produit_id', 'date_expiration']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
