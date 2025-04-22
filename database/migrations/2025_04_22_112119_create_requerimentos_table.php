<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('requerimentos', function (Blueprint $table) {
            $table->id();
            $table->string('observacoes')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('discente_id');
            $table->unsignedBigInteger('tipo_requerimento_id');
            $table->string('status')->default('pendente');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('discente_id')->references('id')->on('discentes');
            $table->foreign('tipo_requerimento_id')->references('id')->on('tipo_requerimentos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requerimentos');
    }
};