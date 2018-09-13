<?php

namespace App\Http\Controllers;

use App\Bico;
use App\Tanque;
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
}
