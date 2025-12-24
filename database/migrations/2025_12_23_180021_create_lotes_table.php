<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();

            // Relación con papeletas
            $table->foreignId('papeleta_id')
                ->constrained('papeletas')
                ->onDelete('cascade');

            $table->string('numero_lote');
            $table->integer('cantidad');
            $table->string('estado')->default('En proceso');
            $table->string('area_actual')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lotes');
    }
};
