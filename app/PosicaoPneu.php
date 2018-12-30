<?php

namespace App;

use App\ModeloVeiculo;
use Illuminate\Database\Eloquent\Model;

class PosicaoPneu extends Model
{
    public $fillable = ['posicao_pneu'];

    public function modeloVeiculos() {
        return $this->belongsTo(ModeloVeiculo::class);
    }
}
