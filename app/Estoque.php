<?php

namespace App;

use App\Produto;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    public $fillable = ['estoque', 'ativo'];

    public function produtos() {
        return $this->belongsToMany(Produto::class);
    }

    public function saldo_produto(Produto $produto) {
        $entradas = DB::table('entrada_estoques')
                        ->join('entrada_estoque_items', 'entrada_estoques.id', 'entrada_estoque_items.entrada_estoque_id')
                        ->where('entrada_estoques.estoque_id', $this->id)
                        ->where('entrada_estoque_items.produto_id', $produto->id)
                        ->sum('entrada_estoque_items.quantidade');
        
        $saidas = 0; //falta implementar assim que o sistema estiver controlando as saídas do estoque;
        
        return $entradas - $saidas;
    }
}
