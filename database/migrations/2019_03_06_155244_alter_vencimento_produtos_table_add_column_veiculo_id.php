<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterVencimentoProdutosTableAddColumnVeiculoId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vencimento_produtos', function (Blueprint $table) {
            $table->unsignedInteger('veiculo_id')->after('ordem_servico_id');
            $table->foreign('veiculo_id')->references('id')->on('veiculos');
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
            $table->dropForeign('vencimento_produtos_veiculo_id_foreign');
            $table->dropColumn('veiculo_id');
        });
    }
}
