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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom')->nullable();

            $table->string('telephone')->nullable()->unique();
            $table->string('email')->nullable()->unique();

            $table->text('adresse')->nullable();
            $table->string('ville')->nullable();

            $table->date('date_naissance')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
