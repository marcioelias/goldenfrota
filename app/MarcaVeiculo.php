<?php

namespace App;

use App\ModeloVeiculo;
use Illuminate\Database\Eloquent\Model;

class MarcaVeiculo extends Model
{
    protected $fillable = ['marca_veiculo', 'ativo'];

    public function modelo_veiculos() {
        return $this->hasMany(ModeloVeiculo::class);
    }

    public function scopeAtivo($query, $ativo = true) {
        return $query->where('ativo', $ativo);
    }
}
