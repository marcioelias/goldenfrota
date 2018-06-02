<?php

namespace App\Http\Controllers;

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
}
