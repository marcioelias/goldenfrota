<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterModeloVeiculosAddForeignTipoControleVeiculo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('modelo_veiculos', function (Blueprint $table) {
            $table->unsignedInteger('tipo_controle_veiculo_id')->nullable()->after('marca_veiculo_id');
            $table->foreign('tipo_controle_veiculo_id')->references('id')->on('tipo_controle_veiculos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modelo_veiculos', function (Blueprint $table) {
            $table->dropForeign('modelo_veiculo_tipo_controle_veiculo_id_foreign');
            $table->dropColumn('tipo_controle_veiculo_id');
        });
    }
}
