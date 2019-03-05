<?php

namespace App;

use App\Veiculo;
use App\MarcaVeiculo;
use App\TipoControleVeiculo;
use Illuminate\Database\Eloquent\Model;

class ModeloVeiculo extends Model
{
    public $fillable = [
        'modelo_veiculo', 
        'marca_veiculo_id', 
        'tipo_controle_veiculo_id',
        'capacidade_tanque', 
        'ativo'];

    public function marca_veiculo() {
        return $this->belongsTo(MarcaVeiculo::class);
    }

    public function veiculos() {
        return $this->hasMany(Veiculo::class);
    }

    public function tipo_controle_veiculo() {
        return $this->belongsTo(TipoControleVeiculo::class);
    }
 }
