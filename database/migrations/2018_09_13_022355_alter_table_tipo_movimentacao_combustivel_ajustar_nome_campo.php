<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTipoMovimentacaoCombustivelAjustarNomeCampo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipo_movimentacao_combustiveis', function (Blueprint $table) {
            $table->dropColumn('tipo_movimetacao_combustivel');
            $table->string('tipo_movimentacao_combustivel')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipo_movimentacao_combustiveis', function (Blueprint $table) {
            $table->dropColumn('tipo_movimentacao_combustivel');
            $table->string('tipo_movimetacao_combustivel')->after('id');
        });
    }
}
