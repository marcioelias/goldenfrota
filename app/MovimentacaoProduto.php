<?php

namespace App;

use App\Estoque;
use App\Produto;
use App\Inventario;
use App\OrdemServico;
use App\SaidaEstoque;
use App\EntradaEstoque;
use App\TipoMovimentacaoProduto;
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

    public function entrada_estoque() {
        return $this->belongsTo(EntradaEstoque::class);
    }

    public function inventario() {
        return $this->belongsTo(Inventario::class);
    }

    public function tipo_movimentacao_produto() {
        return $this->belongsTo(TipoMovimentacaoProduto::class);
    }

    public function produto() {
        return $this->belongsTo(Produto::class);
    }

    public function estoque() {
        return $this->belongsTo(Estoque::class);
    }

    public function saida_estoque() {
        return $this->belongsTo(SaidaEstoque::class);
    }

    public function ordem_servico() {
        return $this->belongsTo(OrdemServico::class);
    }
}
