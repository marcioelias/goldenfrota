<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableMovimentacaoCombustivelTurnFkAbastecimentoCascade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimentacao_combustiveis', function (Blueprint $table) {
            $table->dropForeign('movimentacao_combustiveis_abastecimento_id_foreign');
            $table->foreign('abastecimento_id')->references('id')->on('abastecimentos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimentacao_combustiveis', function (Blueprint $table) {
            $table->dropForeign('movimentacao_combustiveis_abastecimento_id_foreign');
            $table->foreign('abastecimento_id')->references('id')->on('abastecimentos');
        });
    }
}
