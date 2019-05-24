<?php

namespace App;

use App\Veiculo;
use Illuminate\Database\Eloquent\Model;

class GrupoVeiculo extends Model
{
    public $fillable = ['grupo_veiculo', 'ativo'];

    public function veiculos() {
        return $this->hasMany(Veiculo::class);
    }

    public function scopeAtivo($query, $ativo = true) {
        return $query->where('ativo', $ativo);
    }
}
