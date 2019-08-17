<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableMovimentacaoCombustiveisAddFieldEntradaTanqueId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimentacao_combustiveis', function (Blueprint $table) {
            $table->integer('entrada_tanque_id')->unsigned()->nullable()->after('abastecimento_id');
            $table->foreign('entrada_tanque_id')->references('id')->on('entrada_tanques')->onDelete('cascade');
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
            $table->dropForeign('movimentacao_combustiveis_entrada_tanque_id_foreign');
            $table->dropColumn('entrada_tanque_id');
        });
    }
}
