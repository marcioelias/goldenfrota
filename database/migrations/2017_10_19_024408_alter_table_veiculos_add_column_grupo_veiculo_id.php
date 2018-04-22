<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVeiculosAddColumnGrupoVeiculoId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->integer('grupo_veiculo_id')->unsigned()->after('tag');
            $table->foreign('grupo_veiculo_id')->references('id')->on('grupo_veiculos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->dropForeign('veiculos_grupo_veiculo_id_foreign');
            $table->dropColumn('grupo_veiculo_id');
        });
    }
}
