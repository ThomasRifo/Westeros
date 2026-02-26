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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            // Nombre legible interno para identificar el archivo
            $table->string('name');

            // Información técnica / de almacenamiento
            $table->string('disk')->default('public'); // disco de Laravel (public, s3, etc.)
            $table->string('path');                   // ruta relativa dentro del disk
            $table->string('mime_type')->nullable();  // image/png, image/jpeg, etc.
            $table->string('type')->nullable();       // imagen, mapa, documento, etc.

            // Metadatos de licencia / atribución (especialmente para imágenes CC)
            $table->string('source_url')->nullable();      // URL original (westeros.org, etc.)
            $table->string('license_name')->nullable();    // CC BY-SA 3.0, etc.
            $table->string('license_url')->nullable();     // https://creativecommons.org/...
            $table->string('author_name')->nullable();     // Westeros.org, autor, etc.
            $table->text('attribution_text')->nullable();  // Texto completo de atribución

            $table->text('description')->nullable();       // Notas internas opcionales
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
