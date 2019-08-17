<?php

namespace App;

use App\Produto;
use App\SaidaEstoque;
use Illuminate\Database\Eloquent\Model;

class SaidaEstoqueItem extends Model
{
    public $fillable = [
        'saida_estoque_id',
        'produto_id',
        'quantidade',
        'valor_unitario',
        'valor_desconto',
        'valor_acrescimo',
    ];

    public function produto() {
        return $this->belongsTo(Produto::class);
    }

    public function saida_estoque() {
        return $this->belongsTo(SaidaEstoque::class);
    }
 }
