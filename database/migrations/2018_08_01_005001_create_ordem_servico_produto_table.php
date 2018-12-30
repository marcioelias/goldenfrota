<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdemServicoProdutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordem_servico_produto', function (Blueprint $table) {
            $table->integer('ordem_servico_id')->unsigned()->index();
            $table->integer('produto_id')->unsigned()->index();
            $table->decimal('quantidade', 10, 3);
            $table->decimal('valor_produto', 10, 3);
            $table->decimal('valor_desconto', 10, 3)->default(0);
            $table->decimal('valor_acrescimo', 10, 3)->default(0);
            $table->decimal('valor_cobrado', 10, 3);
            $table->foreign('ordem_servico_id')->references('id')->on('ordem_servicos')->onDelete('cascade');
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
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
        Schema::table('ordem_servico_produto', function (Blueprint $table) {
            //
        });
    }
}
