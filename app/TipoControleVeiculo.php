<?php

namespace App;

use App\ModeloVeiculo;
use Illuminate\Database\Eloquent\Model;

class TipoControleVeiculo extends Model
{
    protected $fillable = [
        'tipo_controle_veiculo'
    ];

    public function modelo_veiculos() {
        return $this->hasMany(ModeloVeiculo::class);
    }
}
