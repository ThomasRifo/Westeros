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
        Schema::create('character_titles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('character_id')
                ->constrained('characters')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('title_id')
                ->constrained('titles')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('event_start_id')
                ->nullable()
                ->constrained('timeline_events')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('event_end_id')
                ->nullable()
                ->constrained('timeline_events')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamps();

            $table->index('character_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_titles');
    }
};
