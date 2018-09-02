<?php

namespace App;

use App\Cliente;
use App\Departamento;
use App\GrupoVeiculo;
use App\Abastecimento;
use App\ModeloVeiculo;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    public $fillable = ['placa', 'tag', 'grupo_veiculo_id', 'cliente_id', 'departamento_id', 'modelo_id', 'ano', 'renavam', 'chassi', 'hodometro', 'media_minima', 'ativo'];

    public function abastecimentos() {
        return $this->hasMany(Abastecimento::class)->orderBy('data_hora_abastecimento', 'asc');
    }

    public function modelo_veiculo() {
        return $this->belongsTo(ModeloVeiculo::class);
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
