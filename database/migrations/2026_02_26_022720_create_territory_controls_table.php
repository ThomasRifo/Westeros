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
        Schema::create('territory_controls', function (Blueprint $table) {
            $table->id();

            // Unidad territorial afectada
            // Puede referir a una macro-región, a un dominio/ciudad, o a ambos niveles.
            $table->foreignId('region_id')
                ->nullable()
                ->constrained('regions')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('domain_id')
                ->nullable()
                ->constrained('domains')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('house_id')
                ->nullable()
                ->constrained('houses')
                ->cascadeOnUpdate()
                ->nullOnDelete();

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

            $table->foreignId('status_id')
                ->nullable()
                ->constrained('statuses')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            // Tipo de control: señor legítimo, castellano, ocupante, etc.
            $table->string('control_type')->nullable();

            $table->timestamps();

            $table->index(['region_id', 'start_event_id']);
            $table->index(['domain_id', 'start_event_id']);
            $table->index(['house_id', 'start_event_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('territory_controls');
    }
};

