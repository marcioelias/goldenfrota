<?php

namespace App;

use App\EntradaEstoque;
use Illuminate\Database\Eloquent\Model;

class MovimentacaoProduto extends Model
{
    public $fillable = [
        'data_movimentacao',
        'estoque_id',
        'produto_id',
        'tipo_movimentacao_produto_id',
        'quantidade_movimentada',
        'entrada_estoque_id'
    ];

    public function entradaEstoque() {
        $this->hasOne(EntradaEstoque::class);
    }
}
