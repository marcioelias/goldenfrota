<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atendente extends Model
{
    public $fillable = ['nome_atendente', 'usuario_atendente', 'senha_atendente', 'ativo'];
}
