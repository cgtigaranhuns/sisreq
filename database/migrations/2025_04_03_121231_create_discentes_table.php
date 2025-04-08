<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    use SoftDeletes;
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('discentes', function (Blueprint $table) {
            $table->id();
            $table->string('matricula')->unique();
            $table->string('nome');
            $table->string('email')->nullable();
            $table->string('telefone')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg')->nullable();
            $table->unsignedBigInteger('campus_id');
            $table->unsignedBigInteger('curso_id');
            $table->string('situacao')->nullable();
            $table->integer('periodo')->nullable();
            $table->string('turno')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('campus_id')->references('id')->on('campus');
            $table->foreign('curso_id')->references('id')->on('cursos');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discentes');
    }
};