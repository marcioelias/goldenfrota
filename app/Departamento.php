<?php

namespace App;

use App\Cliente;
use App\SaidaEstoque;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    public $fillable = ['departamento', 'cliente_id', 'ativo'];

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function veiculos() {
        return $this->hasMany(Veiculo::class);
    }

    public function saida_estoque() {
        return $this->belongsTo(SaidaEstoque::class);
    }

    public function scopeAtivo($query, $ativo = true) {
        return $query->where('ativo', $ativo);
    }
}
