<?php

namespace App;

use App\Servico;
use Illuminate\Database\Eloquent\Model;

class GrupoServico extends Model
{
    protected $fillable = ['grupo_servico', 'ativo'];

    public function servicos() {
        return $this->hasMany(Servico::class);
    }

    public function scopeAtivo($query, $ativo = true) {
        return $query->where('ativo', $ativo);
    }
}