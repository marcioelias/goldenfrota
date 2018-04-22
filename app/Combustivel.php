<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Combustivel extends Model
{
    public $table = 'combustiveis';

    public $fillable = ['descricao', 'descricao_reduzida', 'valor', 'ativo'];

    public $fields = array (
        'id' => [
            'type' => 'numeric',
            'label' =>  'Id'
        ]
    );

    public function tanques() {
        return $this->hasMany('App\Tanque');
    }
}
