<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAfericoesSetForeignAbastecimentoCascade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('afericoes', function (Blueprint $table) {
            $table->dropForeign('afericoes_abastecimento_id_foreign');
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
        Schema::table('afericoes', function (Blueprint $table) {
            $table->dropForeign('afericoes_abastecimento_id_foreign');
            $table->foreign('abastecimento_id')->references('id')->on('abastecimentos');
        });
    }
}
