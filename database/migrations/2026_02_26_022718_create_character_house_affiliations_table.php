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
        Schema::create('character_house_affiliations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('character_id')
                ->constrained('characters')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('house_id')
                ->constrained('houses')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('type_affiliation_id')
                ->nullable()
                ->constrained('type_affiliations')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            // Opcionalmente, eventos de inicio/fin de esta afiliación
            $table->foreignId('start_event_id')
                ->nullable()
                ->constrained('timeline_events')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('end_event_id')
                ->nullable()
                ->constrained('timeline_events')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['character_id', 'house_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_house_affiliations');
    }
};
