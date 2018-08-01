<?php

namespace App;

use App\User;
use App\Veiculo;
use App\OrdemServicoProduto;
use App\OrdemServicoServico;
use Illuminate\Database\Eloquent\Model;

class OrdemServico extends Model
{
    protected $fillable = [
        'fechada',
        'veiculo_id',
        'km_veiculo',
        'obs', 
        'user_id'
    ];

    public function veiculo() {
        return $this->belongsTo(Veiculo::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function servicos() {
        return $this->hasMany(OrdemServicoServico::class);
    }

    public function produtos() {
        return $this->hasMany(OrdemServicoProduto::class);
    }
}
