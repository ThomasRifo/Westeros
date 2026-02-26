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
        Schema::create('timeline_events', function (Blueprint $table) {
            $table->id();

            // Relaciones principales
            $table->foreignId('era_id')
                ->constrained('eras')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('type_event_id')
                ->nullable()
                ->constrained('type_events')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            // Localización principal asociada al evento (opcional)
            $table->foreignId('map_location_id')
                ->nullable()
                ->constrained('map_locations')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            // Tiempo
            $table->integer('year');               // año dentro del calendario
            $table->unsignedSmallInteger('sequence_order');      // orden dentro del año
            $table->unsignedSmallInteger('end_sequence_order')
                ->nullable();                      // para eventos que abarcan varias secuencias
            $table->integer('timeline_tick');      // año * 100 + sequence_order (o similar)

            // Datos descriptivos
            $table->string('name');
            $table->text('summary')->nullable();
            $table->text('description')->nullable();
            $table->text('context_note')->nullable(); // texto pensado para la IA / wiki

            $table->timestamps();

            $table->index(['era_id', 'year', 'sequence_order']);
            $table->index('timeline_tick');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeline_events');
    }
};
