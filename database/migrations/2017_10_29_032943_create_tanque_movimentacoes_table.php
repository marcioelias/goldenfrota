<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTanqueMovimentacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanque_movimentacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('entrada_combustivel');
            $table->date('data_movimentacao');
            $table->string('documento')->nullable;
            $table->integer('tanque_id')->unsigned();
            $table->decimal('quantidade_combustivel', 15, 2);
            $table->boolean('ativo')->default(true);
            $table->foreign('tanque_id')->references('id')->on('tanques')->onDelete('cascade');
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
        Schema::dropIfExists('tanque_movimentacaos');
    }
}
