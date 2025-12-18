<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('papeletas', function (Blueprint $table) {
            $table->id();
            $table->string('cliente');
            $table->string('modelo');
            $table->string('talla')->nullable();
            $table->string('marca')->nullable();
            $table->string('color')->nullable();
            $table->string('material')->nullable();
            $table->integer('piezas_totales');
            $table->string('imagen_diseño')->nullable();
            $table->text('observaciones')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->enum('estado', [
                'Programado',
                'En Tejedora',
                'En Producción',
                'En Calidad',
                'Listo para Envío',
                'Enviado',
                'Cerrado'
            ])->default('Programado');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('papeletas');
    }
};
