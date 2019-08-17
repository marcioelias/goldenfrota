<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdemServicoStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Limpando tabela ordem_servico_status');
        $this->truncateOrdemServicoStatusTable();

        $this->command->info('Criando Status de Ordem de Serviço');

        DB::table('ordem_servico_status')->insert(
            [
                [
                    'id' => 1,
                    'os_status' => 'Aberta',
                    'em_aberto' => true
                ],
                [
                    'id' => 2,
                    'os_status' => 'Fechada',
                    'em_aberto' => false
                ]
            ]
        );
    }

    public function truncateOrdemServicoStatusTable() {
        Schema::disableForeignKeyConstraints();
        DB::table('ordem_servico_status')->truncate();
        \App\OrdemServicoStatus::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
