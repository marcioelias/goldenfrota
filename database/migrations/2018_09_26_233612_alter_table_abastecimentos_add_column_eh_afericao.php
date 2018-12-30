<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAbastecimentosAddColumnEhAfericao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abastecimentos', function (Blueprint $table) {
            $table->boolean('eh_afericao')->default(false)->after('obs_abastecimento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abastecimentos', function (Blueprint $table) {
            $table->dropColumn('eh_afericao');
        });
    }
}
