<?php

namespace App;

use App\Produto;
use App\MovimentacaoProduto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    public $fillable = ['estoque', 'permite_estoque_negativo', 'ativo'];

    public function produtos() {
        return $this->belongsToMany(Produto::class);
    }

    public function movimentacao_produtos() {
        return $this->hasMany(MovimentacaoProduto::class);
    }

    public function saldo_produto(Produto $produto) { 
        $saldo = DB::table('movimentacao_produtos')
                    ->select(
                        'produtos.id',
                        DB::raw(
                            'SUM(
                                CASE tipo_movimentacao_produtos.eh_entrada
                                    WHEN 1 THEN
                                        movimentacao_produtos.quantidade_movimentada
                                    WHEN 0 THEN
                                        movimentacao_produtos.quantidade_movimentada * -1
                                END
                            ) as posicao'
                        )
                    )
                    ->groupBy('produtos.id')
                    ->leftJoin('produtos', 'produtos.id', 'movimentacao_produtos.produto_id')
                    ->leftJoin('tipo_movimentacao_produtos', 'tipo_movimentacao_produtos.id', 'movimentacao_produtos.tipo_movimentacao_produto_id')
                    ->where('produtos.id', $produto->id)
                    ->first();
        if (isset($saldo->posicao)) {
            return $saldo->posicao;
        } else {
            return 0;
        }
    }
}
