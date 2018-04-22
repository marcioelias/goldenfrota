<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableGrupoVeiculosAddColumnAtivo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grupo_veiculos', function (Blueprint $table) {
            $table->boolean('ativo')->default(true)->after('grupo_veiculo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grupo_veiculos', function (Blueprint $table) {
            $table->dropColumn('ativo');
        });
    }
}
