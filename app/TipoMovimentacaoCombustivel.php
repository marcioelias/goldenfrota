<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMovimentacaoCombustivel extends Model
{
    protected $table = 'tipo_movimentacao_combustiveis';

    protected $fillable = [
        'tipo_movimentacao_combustivel', 'eh_entrada'
    ];
}
