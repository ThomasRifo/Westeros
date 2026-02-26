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
        Schema::create('dragon_riders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('dragon_id')
                ->constrained('dragons')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('character_id')
                ->constrained('characters')
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

            $table->foreignId('status_id')
                ->nullable()
                ->constrained('statuses')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['dragon_id', 'character_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dragon_riders');
    }
};

