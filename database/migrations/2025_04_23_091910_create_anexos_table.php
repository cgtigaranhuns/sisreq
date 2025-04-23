<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('anexos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requerimento_id')->constrained()->onDelete('cascade');
            $table->string('caminho');
            $table->string('nome_original');
            $table->string('mime_type')->nullable();
            $table->unsignedInteger('tamanho')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('anexos');
    }
};