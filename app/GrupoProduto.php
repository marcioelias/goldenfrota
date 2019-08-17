<?php

namespace App;

use App\Produto;
use Illuminate\Database\Eloquent\Model;

class GrupoProduto extends Model
{
    protected $fillable = ['grupo_produto', 'ativo'];

    public function produtos() {
        return $this->hasMany(Produto::class);
    }

    public function scopeAtivo($query, $ativo = true) {
        return $query->where('ativo', $ativo);
    }
}
