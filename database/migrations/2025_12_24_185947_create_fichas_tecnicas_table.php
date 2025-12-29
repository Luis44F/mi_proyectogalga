<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('fichas_tecnicas', function (Blueprint $table) {
            $table->id();

            // Relación con papeleta
            $table->foreignId('papeleta_id')
                ->constrained('papeletas')
                ->onDelete('cascade');

            // Imagen del diseño
            $table->string('imagen')->nullable();

            // Datos técnicos en JSON
            $table->json('medidas_json')->nullable();
            $table->json('pantones_json')->nullable();
            $table->json('colores_json')->nullable();

            // Especificaciones generales
            $table->text('especificaciones')->nullable();
            $table->text('descripcion')->nullable();

            // Materiales y estructura
            $table->string('tipo_fibras')->nullable();
            $table->string('estructura')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fichas_tecnicas');
    }
};
