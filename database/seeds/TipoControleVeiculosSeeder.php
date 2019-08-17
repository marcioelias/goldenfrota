<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoControleVeiculosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Limpando tabela tipo_controle_veiculos');
        $this->truncateTipoControleVeiculosTable();

        $this->command->info('Criando Tipo de Controle de Veículos');

        DB::table('tipo_controle_veiculos')->insert(
            [
                [
                    'id' => 1,
                    'tipo_controle_veiculo' => 'Km percorridos'
                ],
                [
                    'id' => 2,
                    'tipo_controle_veiculo' => 'Horas trabalhadas'
                ]
            ]
        );

        foreach (\App\ModeloVeiculo::all() as $modelo) {
            $this->command->info('Atualizando modelo: '.$modelo->modelo_veiculo);
            $modelo->tipo_controle_veiculo_id = 1; //padrão controlar por km percorridos
            $modelo->save();
        }
    }

    public function truncateTipoControleVeiculosTable() {
        Schema::disableForeignKeyConstraints();
        DB::table('tipo_controle_veiculos')->truncate();
        \App\TipoControleVeiculo::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
