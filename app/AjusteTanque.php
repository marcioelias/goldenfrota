<?php

namespace App;

use App\User;
use App\Tanque;
use App\MovimentacaoCombustivel;
use Illuminate\Database\Eloquent\Model;

class AjusteTanque extends Model
{
    protected $fillable = [
        'tanque_id',
        'quantidade_informada',
        'quantidade_ajuste',
        'user_id'
    ];

    public function tanque() {
        return $this->belongsTo(Tanque::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function movimentacao_combustivel() {
        return $this->hasMany(MovimentacaoCombustivel::class);
    }
}
