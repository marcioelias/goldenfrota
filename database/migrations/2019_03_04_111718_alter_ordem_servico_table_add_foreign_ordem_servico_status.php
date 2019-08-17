<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrdemServicoTableAddForeignOrdemServicoStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordem_servicos', function (Blueprint $table) {
            $table->unsignedInteger('ordem_servico_status_id')->after('user_id')->default(1);
            $table->foreign('ordem_servico_status_id')->references('id')->on('ordem_servico_status');
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
            $table->dropForeign('ordem_servicos_ordem_servico_status_id_foreign');
            $table->dropColumn('ordem_servico_status_id');
        });
    }
}
