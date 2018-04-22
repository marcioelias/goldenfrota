<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVeiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('placa')->unique();
            $table->string('tag')->nullable();
            $table->integer('cliente_id')->unsigned();
            $table->integer('modelo_veiculo_id')->unsigned();
            $table->integer('ano');
            $table->string('renavam')->nullable();
            $table->string('chassi')->nullable();
            $table->integer('hodometro')->default(0);
            $table->float('media_minima', 8, 2)->default(0);
            $table->boolean('ativo')->default(true);
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('modelo_veiculo_id')->references('id')->on('modelo_veiculos');
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
        Schema::dropIfExists('veiculos');
    }
}
