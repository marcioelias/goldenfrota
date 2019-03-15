<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVencimentoProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vencimento_produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ordem_servico_id');
            $table->unsignedInteger('produto_id');
            $table->unsignedInteger('proxima_troca_dias');
            $table->double('proxima_troca_km_horas', 15, 1);
            $table->boolean('proximo_vencer')->default(false);
            $table->boolean('vencido')->default(false);
            $table->boolean('troca_efetuada')->default(false);
            $table->foreign('ordem_servico_id')->references('id')->on('ordem_servicos');
            $table->foreign('produto_id')->references('id')->on('produtos');
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
        Schema::dropIfExists('vencimento_produtos');
    }
}
