<?php

use Illuminate\Database\Seeder;

class UnidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unidades')->insert([[
            'unidade' => 'UN',
            'permite_fracionamento' => false
        ],
        [
            'unidade' => 'LT',
            'permite_fracionamento' => true
        ],
        [
            'unidade' => 'KG',
            'permite_fracionamento' => true
        ]]);
    }
}
