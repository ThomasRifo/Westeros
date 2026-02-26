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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();

            // Casa asociada por defecto / icónica de este dominio / ciudad (opcional)
            $table->foreignId('default_house_id')
                ->nullable()
                ->constrained('houses')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('region_id')
                ->nullable()
                ->constrained('regions')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('svg_path')->nullable();

            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
