<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('registro_fases', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('lote_id');
            $table->unsignedBigInteger('papeleta_id');

            $table->enum('fase', [
                'HILVANADO',
                'PLANCHADO_LIENZOS',
                'CORTE',
                'CONFECCION',
                'DESHILADO',
                'PLANCHA_FINAL',
                'CALIDAD',
                'EMBALAJE',
                'CONTEO_FINAL',
                'DISTRIBUCION'
            ]);

            $table->enum('estado_fase', [
                'PENDIENTE',
                'EN_PROCESO',
                'COMPLETADA',
                'BLOQUEADA',
                'CANCELADA'
            ])->default('PENDIENTE');

            // ⏱️ TIEMPOS
            $table->timestamp('fecha_inicio')->nullable();
            $table->timestamp('fecha_fin')->nullable();

            // 📊 DATOS FLEXIBLES
            $table->json('datos')->nullable();

            // ✅ CHECK SUPERVISOR
            $table->boolean('check_supervisor')->default(false);
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->timestamp('fecha_check')->nullable();

            // ⛔ CONTROL ADMINISTRADOR
            $table->boolean('cancelado')->default(false);
            $table->unsignedBigInteger('cancelado_por')->nullable();
            $table->timestamp('fecha_cancelacion')->nullable();
            $table->text('motivo_cancelacion')->nullable();

            $table->timestamps();

            // 🔗 RELACIONES
            $table->foreign('lote_id')->references('id')->on('lotes');
            $table->foreign('papeleta_id')->references('id')->on('papeletas');
            $table->foreign('supervisor_id')->references('id')->on('users');
            $table->foreign('cancelado_por')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registro_fases');
    }
};