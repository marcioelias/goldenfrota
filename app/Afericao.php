<?php

namespace App;

use App\User;
use App\Abastecimento;
use App\MovimentacaoCombustivel;
use Illuminate\Database\Eloquent\Model;

class Afericao extends Model
{
    protected $table = 'afericoes';

    protected $fillable = [
        'abastecimento_id',
        'user_id'
    ];

    public function abastecimento() {
        return $this->belongsTo(Abastecimento::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function movimentacao_combustivel() {
        return $this->hasOne(MovimentacaoCombustivel::class);
    }
}
