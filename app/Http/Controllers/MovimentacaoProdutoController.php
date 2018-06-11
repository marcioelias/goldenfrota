<?php

namespace App\Http\Controllers;

use App\Produto;
use App\Inventario;
use App\EntradaEstoque;
use App\MovimentacaoProduto;
use Illuminate\Http\Request;

class MovimentacaoProdutoController extends Controller
{
    static public function entradaEstoque(EntradaEstoque $entradaEstoque) {
        try {
            foreach ($entradaEstoque->entrada_estoque_items as $item) {
                $entradaEstoque->movimentacao_produto()->create([
                    'data_movimentacao' => $entradaEstoque->data_entrada,
                    'estoque_id' => $entradaEstoque->estoque_id,
                    'produto_id' => $item->produto_id,
                    'tipo_movimentacao_produto_id' => 1,
                    'quantidade_movimentada' => $item->quantidade,
                    'entrada_estoque_id' => $entradaEstoque->id
                ]);
            }

            return true;
                /* $entradas[] = [
                    'data_movimentacao_produto' => $entradaEstoque->data_entrada,
                    'estoque_id' => $entradaEstoque->estoque_id,
                    'produto_id' => $item->produto_id,
                    'tipo_movimentacao_produto_id' => 1,
                    'quantidade_movimentada' => $item->quantidade,
                    'entrada_estoque_id' => $entradaEstoque->id
                ];
            }
            return $entradaEstoque->movimentacao_produto()->createMany($entradas); */

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        } 
    }


    static public function consolidarInventario(Inventario $inventario) {
        try {
            foreach ($inventario->inventario_items as $item) {
                /* 
                    3 = Entrada - Inventario
                    4 = Saída - Inventário
                */
                $tipoMov = ($item->qtd_ajuste > 0) ? 3 : 4;
                $qtd = ($item->qtd_ajuste < 0) ? $item->qtd_ajuste * -1 : $item->qtd_ajuste;

                $inventario->movimentacao_produto()->create([
                    'data_movimentacao' => $inventario->data_fechamento,
                    'estoque_id' => $inventario->estoque_id,
                    'produto_id' => $item->produto_id,
                    'tipo_movimentacao_produto_id' =>  $tipoMov,
                    'quantidade_movimentada' => $qtd,
                    'inventario_id' => $inventario->id
                ]);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    static public function saldoProduto(Produto $produto) {
        try {
            $entradas = (new MovimentacaoProduto)->produto()->get();
            //->tipo_movimentacao_produto()->where('eh_entrada', true)->get();

            dd($entradas);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
