<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdemServicoServicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordem_servico_servico', function (Blueprint $table) {
            $table->integer('ordem_servico_id')->unsigned()->index();
            $table->integer('servico_id')->unsigned()->index();
            $table->decimal('valor_servico', 10, 3);
            $table->decimal('valor_desconto', 10, 3)->default(0);
            $table->decimal('valor_acrescimo', 10, 3)->default(0);
            $table->decimal('valor_cobrado', 10, 3);
            $table->foreign('ordem_servico_id')->references('id')->on('ordem_servicos')->onDelete('cascade');
            $table->foreign('servico_id')->references('id')->on('servicos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ordem_servico_servico', function (Blueprint $table) {
            //
        });
    }
}
