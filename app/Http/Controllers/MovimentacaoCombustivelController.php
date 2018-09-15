<?php

namespace App\Http\Controllers;

use App\Bico;
use App\Tanque;
use App\AjusteTanque;
use App\Abastecimento;
use App\EntradaTanque;
use Illuminate\Http\Request;

class MovimentacaoCombustivelController extends Controller
{
    static public function entradaTanque(EntradaTanque $entradaTanque) {
        try {
            foreach ($entradaTanque->entrada_tanque_items as $item) {
                $entradaTanque->movimentacao_combustivel()->create([
                    'tanque_id' => $item->tanque_id,
                    'tipo_movimentacao_combustivel_id' => 1,  /* Entrada */
                    'quantidade' => $item->quantidade,
                    'entrada_tanque_id' => $entradaTanque->id
                ]);
            }

            return true;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        } 
    }


    static public function saidaAbastecimento(Abastecimento $abastecimento) {
        try {
            $bico = Bico::select('tanque_id')
                            ->where('id', $abastecimento->bico_id)
                            ->first();

            $abastecimento->movimentacao_combustivel()->create([
                'tanque_id' => $bico->tanque_id,
                'tipo_movimentacao_combustivel_id' => '2', /* Abastecimento */
                'quantidade' => $abastecimento->volume_abastecimento,
                'abastecimento_id' => $abastecimento->id
            ]);

            return true;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        } 
    }

    static public function ajustarSaldoTanque(AjusteTanque $ajusteTanque) {
        try {
            /* 
                5: Entrada - Ajuste
                6: Saida - Ajuste
            */
            $tipoMovimentacao = ($ajusteTanque->quantidade_ajuste > 0) ? 5 : 6;
            $volumeAjustado = ($ajusteTanque->quantidade_ajuste > 0) ? $ajusteTanque->quantidade_ajuste : ($ajusteTanque->quantidade_ajuste * -1);

            $ajusteTanque->movimentacao_combustivel()->create([
                'tanque_id' => $ajusteTanque->tanque_id,
                'tipo_movimentacao_combustivel_id' => $tipoMovimentacao,
                'quantidade' => $volumeAjustado
            ]);

            return true;
        } catch (\Exception $e) {
            throw new \Exception('Erro ao ajustar tanque: '.$e->getMessage());
        }
    }
}
