<?php

namespace App;

use App\Servico;
use Illuminate\Database\Eloquent\Model;

class GrupoServico extends Model
{
    protected $fillable = ['grupo_servico'];

    public function servicos() {
        return $this->hasMany(Servico::class);
    }
}