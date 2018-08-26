<?php

namespace App;

use App\Produto;
use App\OrdemServico;
use Illuminate\Database\Eloquent\Model;

class OrdemServicoProduto extends Model
{
    protected $table = 'ordem_servico_produto';

    protected $fillable = [
        'ordem_servico_id',
        'produto_id',
        'quantidade',
        'valor_produto',
        'valor_desconto',
        'valor_acrescimo',
        'valor_cobrado'
    ];

    public function ordem_servico() {
        return $this->belongsTo(OrdemServico::class);
    }

    public function produto() {
        return $this->belongsTo(Produto::class);
    }

}
