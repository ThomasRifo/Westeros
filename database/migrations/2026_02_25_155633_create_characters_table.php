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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();

            $table->foreignId('house_id')
                ->nullable()
                ->constrained('houses')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('name');           // Nombre completo
            $table->string('nickname')->nullable();

            $table->integer('birth_year')->nullable();
            $table->integer('death_year')->nullable();

            $table->string('gender')->nullable();

            $table->text('basic_data')->nullable(); // resumen biográfico base

            $table->timestamps();

            $table->index('house_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
