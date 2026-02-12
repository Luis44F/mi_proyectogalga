<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('flujo_produccion', function (Blueprint $table) {
            $table->id();

            // 1. Relación con lote
            $table->foreignId('lote_id')
                ->constrained('lotes')
                ->onDelete('cascade');

            // 2. Control de Flujo (Campos añadidos para el Motor)
            $table->string('fase'); // Ej: 'Corte', 'Costura', etc.
            $table->integer('orden'); // Para saber qué fase va primero
            $table->boolean('check_proceso')->default(false); // Estado de completado

            // 3. Área responsable
            $table->string('area');

            // 4. Fechas y tiempos
            $table->timestamp('fecha_inicio')->nullable();
            $table->timestamp('fecha_fin')->nullable();

            // 5. Conteos
            $table->integer('conteo_inicial')->nullable();
            $table->integer('conteo_final')->nullable();

            // 6. Operador responsable
            $table->foreignId('operador_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            
            // 7. Evidencia y Fallas
            $table->string('evidencia_foto')->nullable(); // Nuevo campo para control visual
            $table->json('fallas_json')->nullable();
            $table->text('observaciones')->nullable();

            // 8. Autorización (Administrador)
            $table->foreignId('autorizado_por')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('fecha_autorizacion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flujo_produccion');
    }
};