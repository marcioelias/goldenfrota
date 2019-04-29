<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterVencimentoProdutosTableAddProdutoSubstitutoIdForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vencimento_produtos', function (Blueprint $table) {
            $table->unsignedInteger('produto_substituto_id')->nullable()->after('ordem_servico_troca_id');
            $table->foreign('produto_substituto_id')->references('id')->on('produtos');
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
            $table->dropForeign('vencimento_produtos_produto_substituto_id_foreign');
            $table->dropColumn('produto_substituto_id');
        });
    }
}
