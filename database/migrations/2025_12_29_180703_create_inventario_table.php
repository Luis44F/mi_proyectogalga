<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();

            // Tipo de inventario (hilo, tela, accesorio, etc.)
            $table->string('tipo');

            // Descripción del material
            $table->string('descripcion');

            // Cantidad disponible
            $table->integer('stock')->default(0);

            // Alerta de stock mínimo
            $table->integer('stock_minimo')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};
