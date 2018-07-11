<?php

namespace App;

use App\Bico;
use App\Combustivel;
use App\MovimentacaoCombustivel;
use Illuminate\Database\Eloquent\Model;

class Tanque extends Model
{
    public $fillable = ['descricao_tanque', 'capacidade', 'combustivel_id', 'posicao', 'ativo'];


    public function combustivel() {
        return $this->belongsTo(Combustivel::class);
    }

    public function bicos() {
        return $this->hasMany(Bico::class);
    }

    public function movimentacao_combustieveis() {
        return $this->hasMany(MovimentacaoCombustivel::class);
    }
}
