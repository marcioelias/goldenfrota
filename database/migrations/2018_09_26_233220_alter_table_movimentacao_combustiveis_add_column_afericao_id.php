<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableMovimentacaoCombustiveisAddColumnAfericaoId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimentacao_combustiveis', function (Blueprint $table) {
            $table->integer('afericao_id')->unsigned()->nullable()->after('ajuste_tanque_id');
            $table->foreign('afericao_id')->references('id')->on('afericoes');
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
            $table->dropForeign('movimentacao_combustiveis_afericao_id_foreign');
            $table->dropColumn('afericao_id');
        });
    }
}
