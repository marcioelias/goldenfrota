<?php

namespace App;

use App\Cliente;
use App\GrupoVeiculo;
use App\Departamento;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    public $fillable = ['placa', 'tag', 'grupo_veiculo_id', 'cliente_id', 'departamento_id', 'modelo_id', 'ano', 'renavam', 'chassi', 'hodometro', 'media_minima', 'ativo'];

    public function abastecimentos() {
        return $this->hasMany('App\Abastecimento');
    }

    public function modelo_veiculo() {
        return $this->belongsTo('App\ModeloVeiculo');
    }

    public function grupo_veiculo() {
        return $this->belongsTo(GrupoVeiculo::class);
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function departamento() {
        return $this->belongsTo(Departamento::class);
    }
}
