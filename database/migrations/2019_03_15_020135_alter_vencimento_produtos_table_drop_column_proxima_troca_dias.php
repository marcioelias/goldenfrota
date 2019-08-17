<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterVencimentoProdutosTableDropColumnProximaTrocaDias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vencimento_produtos', function (Blueprint $table) {
            $table->dropColumn('proxima_troca_dias');
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
            $table->unsignedInteger('proxima_troca_dias')->after('produto_id');
        });
    }
}
