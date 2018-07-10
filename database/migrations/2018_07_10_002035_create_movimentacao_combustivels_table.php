<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimentacaoCombustivelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentacao_combustiveis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tanque_id')->unsigned();
            $table->integer('tipo_movimentacao_combustivel_id')->unsigned();
            $table->double('quantidade', 10, 3);
            $table->integer('abastecimento_id')->unsigned()->nullable();
            $table->foreign('tanque_id')->references('id')->on('tanques');
            $table->foreign('tipo_movimentacao_combustivel_id', 'tp_mov_comb_id')->references('id')->on('tipo_movimentacao_combustiveis');
            $table->foreign('abastecimento_id')->references('id')->on('abastecimentos');
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
        Schema::dropIfExists('movimentacao_combustiveis');
    }
}
