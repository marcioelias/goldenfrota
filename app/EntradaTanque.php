<?php

namespace App;

use App\Fornecedor;
use App\EntradaTanqueItem;
use App\MovimentacaoCombustivel;
use Illuminate\Database\Eloquent\Model;

class EntradaTanque extends Model
{
    protected $fillable = [
        'nr_docto',
        'serie',
        'data_doc',
        'data_entrada',
        'fornecedor_id',
        'valor_total'
    ];

    public function entrada_tanque_items() {
        return $this->hasMany(EntradaTanqueItem::class);
    }

    public function fornecedor() {
        return $this->belongsTo(Fornecedor::class);
    }

    public function movimentacao_combustivel() {
        return $this->hasMany(MovimentacaoCombustivel::class);
    }
}
