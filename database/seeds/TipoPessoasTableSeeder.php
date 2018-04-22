<?php

use Illuminate\Database\Seeder;

class TipoPessoasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_pessoas')->insert([
            [
                'tipo_pessoa' => 'Física'
            ],
            [
                'tipo_pessoa' => 'Jurídica'
            ]
        ]);
    }
}
