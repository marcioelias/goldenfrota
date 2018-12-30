<?php

namespace App;

use App\Servico;
use App\OrdemServico;
use Illuminate\Database\Eloquent\Model;

class OrdemServicoServico extends Model
{
    protected $table = 'ordem_servico_servico';

    protected $fillable = [
        'ordem_servico_id',
        'servico_id',
        'valor_servico',
        'valor_desconto',
        'valor_acrescimo',
        'valor_cobrado'
    ];

    public function ordem_servico() {
        return $this->belongsTo(OrdemServico::class);
    }

    public function servico() {
        return $this->belongsTo(Servico::class);
    }
}
