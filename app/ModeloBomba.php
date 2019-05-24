<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModeloBomba extends Model
{
    public $fillable = ['modelo_bomba', 'num_bicos', 'ativo'];

    public function scopeAtivo($query, $ativo = true) {
        return $query->where('ativo', $ativo);
    }
}
