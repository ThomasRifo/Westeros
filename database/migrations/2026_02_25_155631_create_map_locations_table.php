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
        Schema::create('map_locations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('type_location_id')
                ->nullable()
                ->constrained('type_locations')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('region_id')
                ->nullable()
                ->constrained('regions')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('domain_id')
                ->nullable()
                ->constrained('domains')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('name');

            // Coordenadas normalizadas 0..1 respecto al mapa base
            $table->double('coord_x');
            $table->double('coord_y');

            // Nivel de snap / zoom o prioridad de colocación (opcional)
            $table->unsignedTinyInteger('snap_level')->default(0);

            $table->string('svg_path_id')->nullable(); // referencia a un path del SVG, si aplica

            $table->string('slug')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();

            $table->index(['region_id', 'type_location_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map_locations');
    }
};

