<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emisor_id');
            $table->unsignedBigInteger('receptor_id');
            $table->text('mensaje');
            $table->string('archivo_adj')->nullable();
            $table->boolean('leido')->default(0);
            $table->timestamps();

            $table->foreign('emisor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receptor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
