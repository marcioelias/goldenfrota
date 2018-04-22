<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tanque extends Model
{
    public $fillable = ['descricao_tanque', 'capacidade', 'combustivel_id', 'posicao', 'ativo'];


    public function combustivel() {
        return $this->belongsTo('App\Combustivel');
    }
}
