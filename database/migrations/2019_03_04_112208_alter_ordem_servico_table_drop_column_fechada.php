<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrdemServicoTableDropColumnFechada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (\App\OrdemServico::all() as $os) {
            $os->ordem_servico_status_id = ($os->fechada == 1) ? 2 : 1;
            $os->save();
        }
        Schema::table('ordem_servicos', function (Blueprint $table) {
            $table->dropColumn('fechada');
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
            $table->boolean('fechada')->after('estoque_id')->default(false);
        });
        foreach (\App\OrdemServico::all() as $os) {
            $os->fechada = ($os->ordem_servico_status_id == 2) ? true : false;
            $os->save();
        }
    }
}
