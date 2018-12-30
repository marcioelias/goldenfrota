<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableMovimentacaoCombustiveisSetForeignAfericaoCascade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimentacao_combustiveis', function (Blueprint $table) {
            $table->dropForeign('movimentacao_combustiveis_afericao_id_foreign');
            $table->foreign('afericao_id')->references('id')->on('afericoes')->onDelete('cascade');
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
            $table->foreign('afericao_id')->references('id')->on('afericoes');
        });
    }
}
