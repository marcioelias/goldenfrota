<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModeloVeiculoPosicaoPneuPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modelo_veiculo_posicao_pneu_', function (Blueprint $table) {
            $table->integer('modelo_veiculo_id')->unsigned();
            $table->integer('posicao_pneu_id')->unsigned();
            $table->foreign('modelo_veiculo_id')->references('id')->on('modelo_veiculos');
            $table->foreign('posicao_pneu_id')->references('id')->on('posicao_pneus');
            $table->primary(['modelo_veiculo_id', 'posicao_pneu_id'], 'modelo_veiculo_posicao_pneu_pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modelo_veiculo_posicao_pneu_');
    }
}
