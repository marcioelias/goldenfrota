<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAbastecimentosFieldNsAutomacaoString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (PHP_VERSION_ID > 70100) {
            Schema::table('abastecimentos', function (Blueprint $table) {
                $table->string('ns_automacao')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (PHP_VERSION_ID > 70100) {
            Schema::table('abastecimentos', function (Blueprint $table) {
                $table->integer('ns_automacao')->change();
            });
        }
    }
}
