<?php

namespace App;

use App\GrupoServico;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    protected $fillable = [
        'servico', 
        'descricao', 
        'grupo_servico_id', 
        'ativo'
    ];

    public function grupo_servico() {
        return $this->belongsTo(GrupoServico::class);
    }
}
