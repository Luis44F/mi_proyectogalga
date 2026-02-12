<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('flujo_produccion', function (Blueprint $table) {

            // Fase del Enum
            $table->string('fase')
                  ->after('lote_id');                                             

            // Orden del proceso
            $table->integer('orden')
                  ->after('fase');

            // Check de finalización
            $table->boolean('check_proceso')
                  ->default(false)
                  ->after('orden');

            // Evidencia fotográfica
            $table->string('evidencia_foto')
                  ->nullable()
                  ->after('operador_id');

        });
    }

    public function down(): void
    {
        Schema::table('flujo_produccion', function (Blueprint $table) {

            $table->dropColumn([
                'fase',
                'orden',
                'check_proceso',
                'evidencia_foto'
            ]);

        });
    }

};
