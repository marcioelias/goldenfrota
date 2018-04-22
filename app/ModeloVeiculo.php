<?php

namespace App;

use App\Veiculo;
use App\MarcaVeiculo;
use Illuminate\Database\Eloquent\Model;

class ModeloVeiculo extends Model
{
    public $fillable = ['modelo_veiculo', 'marca_veiculo_id', 'capacidade_tanque', 'ativo'];

    public function marca_veiculo() {
        return $this->belongsTo(MarcaVeiculo::class);
    }

    public function veiculos() {
        return $this->hasMany(Veiculo::class);
    }
 }
