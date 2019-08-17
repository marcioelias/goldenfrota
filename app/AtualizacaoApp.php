<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class AtualizacaoApp extends Model
{
    protected $guarded = [];

    public function scopeNaoImportado($query, $idUltimaAtualizacao = 0) {
        $query->where('id', '>', $idUltimaAtualizacao);
    }
}
