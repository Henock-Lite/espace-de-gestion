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
        Schema::create('mouvements_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lot_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('produit_id')
                ->constrained()
                ->restrictOnDelete();
            $table->index(['lot_id', 'type_mouvement']);
            $table->index(['produit_id', 'date_mouvement']);

            $table->enum('type_mouvement', [
                'entree',
                'vente',
                'perte',
                'ajustement',
                'retour'
            ]);

            $table->integer('quantite');

            $table->integer('stock_avant');
            $table->integer('stock_apres');

            $table->text('description')->nullable();

            $table->dateTime('date_mouvement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mouvements_stock');
    }
};
