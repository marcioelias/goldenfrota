<?php

namespace App;

use App\Produto;
use App\OrdemServico;
use Illuminate\Database\Eloquent\Model;

class VencimentoProduto extends Model
{
    protected $guarded = [];

    public function produto() {
        return $this->belongsTo(Produto::class);
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

}
