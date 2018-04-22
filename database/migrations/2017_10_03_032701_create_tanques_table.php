<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTanquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanques', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao_tanque')->unique();
            $table->integer('combustivel_id')->unsigned();
            $table->decimal('capacidade', 9, 3);
            $table->decimal('posicao', 9, 3)->default(0);
            $table->boolean('ativo')->default(true);
            $table->foreign('combustivel_id')->references('id')->on('combustiveis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tanques');
    }
}
