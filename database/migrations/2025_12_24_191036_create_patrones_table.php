<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('patrones', function (Blueprint $table) {
            $table->id();

            // Relación con ficha técnica
            $table->foreignId('ficha_id')
                ->constrained('fichas_tecnicas')
                ->onDelete('cascade');

            // Archivo PDF del patrón
            $table->string('archivo_pdf');

            // Estado del patrón
            $table->string('estado')->default('borrador'); 
            // borrador | en_revision | aprobado

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patrones');
    }
};
