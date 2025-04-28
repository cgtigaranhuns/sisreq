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
        Schema::create('anexo_acomps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('acompanhamento_id')->constrained()->onDelete('cascade');
            $table->string('caminho');
            $table->string('nome_original');
            $table->string('mime_type')->nullable();
            $table->unsignedInteger('tamanho')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anexo_acomps');
    }
};