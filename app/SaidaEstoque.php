<?php

namespace App;

use App\Cliente;
use App\Estoque;
use App\Departamento;
use App\SaidaEstoqueItem;
use Illuminate\Database\Eloquent\Model;

class SaidaEstoque extends Model
{
    public $fillable = [
        'cliente_id',
        'departamento_id',
        'estoque_id',
        'valor_total',
        'data_saida',
        'obs'
    ];

    public function saida_estoque_items() {
        return $this->hasMany(SaidaEstoqueItem::class);
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function departamento() {
        return $this->belongsTo(Departamento::class);
    }

    public function estoque() {
        return $this->belongsTo(Estoque::class);
    }

    public function movimentacao_produto() {
        return $this->hasMany(MovimentacaoProduto::class);
    }
}
