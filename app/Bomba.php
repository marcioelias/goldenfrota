<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bomba extends Model
{
    public $fillable = ['descricao_bomba', 'tipo_bomba_id', 'modelo_bomba_id', 'ativo'];
}
