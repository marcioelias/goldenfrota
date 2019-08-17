<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdemServicoStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordem_servico_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('os_status');
            $table->boolean('em_aberto')->default(true);
            $table->timestamps();
        });

        Artisan::call('db:seed', array('--class' => 'OrdemServicoStatusSeeder'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordem_servico_status');
    }
}
