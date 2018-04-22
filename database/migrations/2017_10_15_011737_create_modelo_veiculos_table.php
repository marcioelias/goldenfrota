<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModeloVeiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modelo_veiculos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('modelo_veiculo')->unique();
            $table->integer('capacidade_tanque');
            $table->integer('marca_veiculo_id')->unsigned();
            $table->foreign('marca_veiculo_id')->references('id')->on('marca_veiculos');
            $table->boolean('ativo')->default(true);
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
        Schema::dropIfExists('modelo_veiculos');
    }
}
