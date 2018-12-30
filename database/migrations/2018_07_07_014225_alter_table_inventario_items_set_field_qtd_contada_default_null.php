<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableInventarioItemsSetFieldQtdContadaDefaultNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventario_items', function (Blueprint $table) {
            $table->dropColumn('qtd_contada');
        });

        Schema::table('inventario_items', function (Blueprint $table) {
            $table->double('qtd_contada', 10, 3)->nullable()->after('qtd_estoque');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventario_items', function (Blueprint $table) {
            $table->dropColumn('qtd_contada');
        });

        Schema::table('inventario_items', function (Blueprint $table) {
            $table->double('qtd_contada', 10, 3)->default(0)->after('qtd_estoque');
        });
    }
}
