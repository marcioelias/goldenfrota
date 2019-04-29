<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterVencimentoProdutosTableAddColumnOrdemServicoTrocaId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vencimento_produtos', function (Blueprint $table) {
            $table->unsignedInteger('ordem_servico_troca_id')->nullable()->after('troca_efetuada');
            $table->foreign('ordem_servico_troca_id')->references('id')->on('ordem_servicos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vencimento_produtos', function (Blueprint $table) {
            $table->dropForeign('vencimento_produtos_ordem_servico_troca_id');
            $table->dropColumn('ordem_servico_troca_id');
        });
    }
}
