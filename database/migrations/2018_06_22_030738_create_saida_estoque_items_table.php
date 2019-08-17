<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaidaEstoqueItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saida_estoque_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('saida_estoque_id')->unsigned();
            $table->integer('produto_id')->unsigned();
            $table->double('quantidade', 10, 3);
            $table->double('valor_unitario', 10, 3);
            $table->double('valor_desconto', 10, 3)->default(0);
            $table->double('valor_acrescimo', 10, 3)->default(0);
            $table->foreign('saida_estoque_id')->references('id')->on('saida_estoques')->onDelete('cascade');
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
        Schema::dropIfExists('saida_estoque_items');
    }
}
