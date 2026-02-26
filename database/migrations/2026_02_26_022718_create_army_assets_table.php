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
        Schema::create('army_assets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('army_id')
                ->constrained('armies')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('asset_id')
                ->constrained('assets')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->integer('quantity')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();

            $table->unique(['army_id', 'asset_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('army_assets');
    }
};
