<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('distribucion', function (Blueprint $table) {
            $table->id();

            // Relación con papeleta
            $table->foreignId('papeleta_id')
                  ->constrained('papeletas')
                  ->onDelete('cascade');

            // Datos de entrega
            $table->date('fecha_envio')->nullable();
            $table->date('fecha_entrega')->nullable();

            // Responsable
            $table->string('responsable');

            // Estados: pendiente, enviado, entregado
            $table->string('estado')->default('pendiente');

            // Observaciones finales
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distribucion');
    }
};
