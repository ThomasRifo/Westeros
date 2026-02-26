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
        Schema::create('event_participants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('timeline_event_id')
                ->constrained('timeline_events')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // Estado dentro del evento (vivo, muerto, herido, desaparecido, etc.)
            $table->foreignId('status_id')
                ->nullable()
                ->constrained('statuses')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            // Participante polimórfico: personaje, ejército, dragón, asset, etc.
            $table->string('entity_type');
            $table->unsignedBigInteger('entity_id');

            // Localización específica en el mapa para este evento (opcional)
            $table->foreignId('map_location_id')
                ->nullable()
                ->constrained('map_locations')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            // Rol en el evento (atacante, defensor, observador, mensajero, etc.)
            $table->string('role')->nullable();

            // Notas cortas de contexto específicas del participante
            $table->text('context_note')->nullable();

            $table->timestamps();

            $table->index(['entity_type', 'entity_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_participants');
    }
};
