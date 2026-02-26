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
        // Emblemas de casas
        Schema::table('houses', function (Blueprint $table) {
            $table->foreignId('emblem_file_id')
                ->nullable()
                ->after('ancestral_weapon')
                ->constrained('files')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });

        // Retratos de personajes
        Schema::table('characters', function (Blueprint $table) {
            $table->foreignId('portrait_file_id')
                ->nullable()
                ->after('nickname')
                ->constrained('files')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });

        // Imágenes de dragones
        Schema::table('dragons', function (Blueprint $table) {
            $table->foreignId('image_file_id')
                ->nullable()
                ->after('secondary_color')
                ->constrained('files')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });

        // Imagen asociada a un asset (opcional)
        Schema::table('assets', function (Blueprint $table) {
            $table->foreignId('file_id')
                ->nullable()
                ->after('type')
                ->constrained('files')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('emblem_file_id');
        });

        Schema::table('characters', function (Blueprint $table) {
            $table->dropConstrainedForeignId('portrait_file_id');
        });

        Schema::table('dragons', function (Blueprint $table) {
            $table->dropConstrainedForeignId('image_file_id');
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->dropConstrainedForeignId('file_id');
        });
    }
};

