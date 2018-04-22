<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    public $fillable = ['produto_descricao', 'produto_desc_red', 'unidade_id', 'grupo_produto_id', 'qtd_estoque', 'valor_unitario'];
}
