<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAbastecimentosAddColumnTanqueMovimentacaoId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abastecimentos', function (Blueprint $table) {
            $table->integer('tanque_movimentacao_id')->unsigned()->nullable();
            $table->foreign('tanque_movimentacao_id')->references('id')->on('tanque_movimentacoes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abastecimentos', function (Blueprint $table) {
            $table->dropForeign('abastecimentos_tanque_movimentacao_id_foreign');
            $table->dropColumn('tanque_movimentacao_id');
        });
    }
}
