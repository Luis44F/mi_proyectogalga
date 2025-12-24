<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('flujo_produccion', function (Blueprint $table) {
            $table->id();

            // Relación con lote
            $table->foreignId('lote_id')
                ->constrained('lotes')
                ->onDelete('cascade');

            // Área del proceso
            $table->string('area');

            // Fechas y tiempos
            $table->timestamp('fecha_inicio')->nullable();
            $table->timestamp('fecha_fin')->nullable();

            // Conteos
            $table->integer('conteo_inicial')->nullable();
            $table->integer('conteo_final')->nullable();

            // Operador responsable
            $table->foreignId('operador_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Fallas y observaciones
            $table->json('fallas_json')->nullable();
            $table->text('observaciones')->nullable();

            // Check del Administrador
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
