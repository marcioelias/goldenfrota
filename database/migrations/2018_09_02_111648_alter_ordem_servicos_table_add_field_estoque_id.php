<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrdemServicosTableAddFieldEstoqueId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordem_servicos', function (Blueprint $table) {
            $table->integer('estoque_id')->nullable()->unsigned()->after('id');
            $table->foreign('estoque_id')->references('id')->on('estoques');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ordem_servicos', function (Blueprint $table) {
            $table->dropForeign('ordem_servicos_estoque_id_foreign');
            $table->dropColumn('estoque_id');
        });
    }
}
