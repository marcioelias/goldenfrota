<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterVencimentoProdutosTableAddColumnDataProximaTroca extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vencimento_produtos', function (Blueprint $table) {
            $table->dateTime('data_proxima_troca')->after('produto_id');
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
            $table->dropColumn('data_proxima_troca');
        });
    }
}
