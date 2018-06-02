<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMovimentacaoProduto extends Model
{
    public $fillable = [
        'tipo_movimentacao_produto',
        'eh_entrada',
        'ativo'
    ];
}
