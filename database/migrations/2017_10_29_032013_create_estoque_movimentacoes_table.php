<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstoqueMovimentacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estoque_movimentacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('entrada_produto');
            $table->date('data_movimentacao');
            $table->string('documento_movimentacao')->nullable();
            $table->integer('produto_id')->unsigned();
            $table->decimal('quantidade_movimentada', 15, 2);
            $table->boolean('ativo')->default(true);
            $table->foreign('produto_id')->references('id')->on('produtos');
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
        Schema::dropIfExists('estoque_movimentacoes');
    }
}
