<?php

namespace App;

use App\Tanque;
use App\Abastecimento;
use App\EntradaTanque;
use App\TipoMovimentacaoCombustivel;
use Illuminate\Database\Eloquent\Model;

class MovimentacaoCombustivel extends Model
{
    protected $table = 'movimentacao_combustiveis';

    protected $fillable = [
        'tanque_id', 
        'tipo_movimentacao_combustivel_id',
        'quantidade',
        'abastecimento_id'
    ];

    public function tanque() {
        return $this->belongsTo(Tanque::class);
    }

    public function tipo_movimentacao_combustivel() {
        return $this->belongsTo(TipoMovimentacaoCombustivel::class);
    }

    public function abastecimento() {
        return $this->belongsTo(Abastecimento::class);
    }

    public function entrada_tanque() {
        return $this->belongsTo(EntradaTanque::class);
    }
}
