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
        Schema::create('houses', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->string('slug')->unique();

            $table->string('words')->nullable();            // Lema de la casa
            $table->string('seat')->nullable();             // Asiento principal (Invernalia, etc.)
            $table->string('ancestral_weapon')->nullable(); // Espada de acero valyrio, etc.
            $table->string('sigil')->nullable(); // SVG path del escudo de la casa

            $table->foreignId('region_id')
                ->nullable()
                ->constrained('regions')
                ->cascadeOnUpdate()
                ->nullOnDelete();   

            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
