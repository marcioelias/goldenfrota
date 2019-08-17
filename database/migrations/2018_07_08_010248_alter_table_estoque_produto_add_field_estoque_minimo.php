<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableEstoqueProdutoAddFieldEstoqueMinimo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estoque_produto', function (Blueprint $table) {
            $table->double('estoque_minimo', 10, 3)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estoque_produto', function (Blueprint $table) {
            $table->dropColumn('estoque_minimo');
        });
    }
}
