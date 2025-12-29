<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('programacion', function (Blueprint $table) {
            $table->id();

            // Relación con papeleta
            $table->foreignId('papeleta_id')
                ->constrained('papeletas')
                ->onDelete('cascade');

            // Archivo principal de programación
            $table->string('archivo_programa');

            // Especificaciones técnicas (JSON)
            $table->json('especificaciones_json')->nullable();

            // Historial de versiones
            $table->json('historial_archivos_json')->nullable();

            // Fecha de programación
            $table->timestamp('fecha')->useCurrent();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programacion');
    }
};
