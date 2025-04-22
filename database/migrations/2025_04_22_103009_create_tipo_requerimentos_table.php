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
        Schema::create('tipo_requerimentos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->string('anexo');
            $table->boolean('infor_complementares')->default(false);
            $table->softDeletes();
            $table->timestamps();
            $table->boolean('status')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_requerimentos');
    }
};