<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableEstoquesAddFieldPermiteEstoqueNegativo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estoques', function (Blueprint $table) {
            $table->boolean('permite_estoque_negativo')->default(false)->after('estoque');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estoques', function (Blueprint $table) {
            $table->dropColumn('permite_estoque_negativo');
        });
    }
}
