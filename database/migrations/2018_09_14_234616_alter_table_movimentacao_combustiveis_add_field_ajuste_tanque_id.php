<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableMovimentacaoCombustiveisAddFieldAjusteTanqueId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimentacao_combustiveis', function (Blueprint $table) {
            $table->integer('ajuste_tanque_id')->unsigned()->nullable()->after('entrada_tanque_id');
            $table->foreign('ajuste_tanque_id')->references('id')->on('ajuste_tanques')->onDelete('cascade');
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
            $table->dropForeign('movimentacao_combustiveis_ajusta_tanque_id_foreign');
            $table->dropColumn('ajuste_tanque_id');
        });
    }
}
