<?php

use App\Abastecimento;
use App\Veiculo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UpdateHodometroVeiculosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Atualizando hodometro dos veiculos cadastrados pelo ultimo abastecimento.');

        foreach(Veiculo::all() as $veiculo) {
            $this->command->info('Obtendo ultimo abastecimento do veículo: ' . $veiculo->placa);
            $abastecimento = Abastecimento::ultimoDoVeiculo($veiculo->id);
            if (!isset($abastecimento->id)) {
                $this->command->alert('Veículo ' . $veiculo->placa.' não possui abastecimentos.');
                $this->command->info('Veículo ' . $veiculo->placa.' NÃO atualizado.');
            } else {
                if ($abastecimento->km_veiculo) {
                    $this->command->info('Atualizando hodometro do veículo: ' . $veiculo->placa.'.');
                    $veiculo->hodometro = $abastecimento->km_veiculo;
                    $veiculo->save();
                }
            }
            $this->command->info('Veículo ' . $veiculo->placa.' atualizado.');
        }
    }
}
