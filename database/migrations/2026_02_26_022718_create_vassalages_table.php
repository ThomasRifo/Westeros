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
        Schema::create('vassalages', function (Blueprint $table) {
            $table->id();

            // Casa vasalla
            $table->foreignId('vassal_house_id')
                ->constrained('houses')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // Casa señorial
            $table->foreignId('liege_house_id')
                ->constrained('houses')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

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

            $table->timestamps();

            $table->index(['vassal_house_id', 'liege_house_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vassalages');
    }
};
