<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMovimentacaoProdutosTableAddFieldOrdemServicoId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimentacao_produtos', function (Blueprint $table) {
            $table->integer('ordem_servico_id')->after('saida_estoque_id')->nullable()->unsigned();
            $table->foreign('ordem_servico_id')->references('id')->on('ordem_servicos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimentacao_produtos', function (Blueprint $table) {
            $table->dropForeign('movimentacao_produtos_ordem_servico_id_foreign');
            $table->dropColumn('ordem_servico_id');
        });
    }
}
