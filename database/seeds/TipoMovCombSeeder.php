<?php

use Illuminate\Database\Seeder;

class TipoMovCombSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Limpando tabela tipo_movimentacao_combustiveis');
        $this->truncateTipoMovimentacaoCombustiveisTable();

        $this->command->info('Criando Tipos de Movimentação de Combustivel');

        DB::table('tipo_movimentacao_combustiveis')->insert(
            [
                [
                    'id' => 1,
                    'tipo_movimentacao_combustivel' => 'Entrada',
                    'eh_entrada' => true
                ],
                [
                    'id' => 2,
                    'tipo_movimentacao_combustivel' => 'Abastecimento',
                    'eh_entrada' => false
                ],
                [
                    'id' => 3,
                    'tipo_movimentacao_combustivel' => 'Entrada - Aferição',
                    'eh_entrada' => true
                ],
                [
                    'id' => 4,
                    'tipo_movimentacao_combustivel' => 'Saída - Aferição',
                    'eh_entrada' => false
                ]
            ]
        );
    }

    public function truncateTipoMovimentacaoCombustiveisTable() {
        Schema::disableForeignKeyConstraints();
        DB::table('tipo_movimentacao_combustiveis')->truncate();
        \App\TipoMovimentacaoCombustivel::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
