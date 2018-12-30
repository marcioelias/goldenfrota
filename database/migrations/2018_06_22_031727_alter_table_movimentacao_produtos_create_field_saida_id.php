<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableMovimentacaoProdutosCreateFieldSaidaId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimentacao_produtos', function (Blueprint $table) {
            $table->integer('saida_estoque_id')->unsigned()->nullable()->after('inventario_id');
            $table->foreign('saida_estoque_id')->references('id')->on('saida_estoques')->onDelete('cascade');
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
            $table->dropForeign('movimentacao_produtos_saida_estoque_id_foreign');
            $table->dropColumn('saida_estoque_id');
        });
    }
}
