<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaidaEstoquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saida_estoques', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id')->unsigned();
            $table->integer('departamento_id')->unsigned()->nullable();
            $table->integer('estoque_id')->unsigned();
            $table->text('obs')->nullable();
            $table->double('valor_total', 10, 3);
            $table->datetime('data_saida');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('departamento_id')->references('id')->on('departamentos');
            $table->foreign('estoque_id')->references('id')->on('estoques');
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
        Schema::dropIfExists('saida_estoques');
    }
}
