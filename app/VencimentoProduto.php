<?php

namespace App;

use App\Produto;
use App\Veiculo;
use App\OrdemServico;
use Illuminate\Database\Eloquent\Model;

class VencimentoProduto extends Model
{
    protected $guarded = [];

    protected $dates = [
        'data_proxima_troca'
    ];

    public function produto() {
        return $this->belongsTo(Produto::class);
    }

    public function veiculo() {
        return $this->belongsTo(Veiculo::class);
    }

    public function ordem_servico() {
        return $this->belongsTo(OrdemServico::class);
    }

    public function scopeVencidos($query) {
        return $query->where('vencido', true)->where('troca_efetuada', false);
    }

    public function scopeProximoVencer($query) {
        return $query->where('proximo_vencer', true)->where('troca_efetuada', false);
    }

    public function scopeTrocaEfetuada($query) {
        return $query->where('troca_efetuada', true);
    }

    public function scopeTrocaNaoEfetuada($query) {
        return $query->where('troca_efetuada', false);
    }

    public function scopeProximoDoVencimentoOuVencido($query, $veiculo = false) {
        $rawVeiculo = ($veiculo) ? 'veiculo_id = '.$veiculo->id : '1 = 1';
        return $query->whereRaw($rawVeiculo)->where('troca_efetuada', false)->where('proximo_vencer', true)->orWhere('vencido', true);
    }
}
