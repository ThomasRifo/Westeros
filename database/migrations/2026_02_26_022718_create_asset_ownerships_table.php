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
        Schema::create('asset_ownerships', function (Blueprint $table) {
            $table->id();

            // Propietario polimórfico: casa, personaje, ejército, etc.
            $table->string('owner_type');
            $table->unsignedBigInteger('owner_id');

            $table->foreignId('asset_id')
                ->constrained('assets')
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

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['owner_type', 'owner_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_ownerships');
    }
};
