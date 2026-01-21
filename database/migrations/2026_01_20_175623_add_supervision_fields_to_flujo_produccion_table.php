<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('flujo_produccion', function (Blueprint $table) {

            // 📦 Datos extensibles por área
            $table->json('datos')->nullable()->after('observaciones');

            // ✅ Control de avance
            $table->boolean('completado')->default(false)->after('datos');

            // 👨‍💼 CHECK DE SUPERVISOR
            $table->boolean('check_supervisor')->default(false)->after('completado');

            $table->foreignId('supervisor_id')
                ->nullable()
                ->after('check_supervisor')
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('fecha_check')->nullable()->after('supervisor_id');

            // 🔒 UNA SOLA ETAPA POR ÁREA Y LOTE
            $table->unique(['lote_id', 'area'], 'flujo_lote_area_unique');
        });
    }

    public function down(): void
    {
        Schema::table('flujo_produccion', function (Blueprint $table) {

            $table->dropUnique('flujo_lote_area_unique');

            $table->dropColumn([
                'datos',
                'completado',
                'check_supervisor',
                'fecha_check'
            ]);

            $table->dropForeign(['supervisor_id']);
            $table->dropColumn('supervisor_id');
        });
    }
};
