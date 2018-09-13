<?php

namespace App;

use App\Veiculo;
use App\TanqueMovimentacao;
use App\MovimentacaoCombustivel;
use Illuminate\Database\Eloquent\Model;

class Abastecimento extends Model
{
    public $fillable = [
        'id_automacao',
        'ns_automacao',
        'bico_id',
        'encerrante_inicial',
        'encerrante_final',
        'valor_abastecimento',
        'valor_litro',
        'volume_abastecimento',
        'atendente_id',
        'veiculo_id',
        'km_veiculo',
        'requisicao_abastecimento',
        'data_hora_abastecimento',
        'ativo',
        'abastecimento_local'
    ];

    public function tanque_movimentacao() {
        return $this->hasOne(TanqueMovimentacao::class);
    }

    public function veiculo() {
        return $this->belongsTo(Veiculo::class);
    }

    public function movimentacao_combustivel() {
        return $this->hasOne(MovimentacaoCombustivel::class);
    }
}
