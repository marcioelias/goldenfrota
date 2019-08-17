<?php

namespace App;

use App\Tanque;
use App\EntradaTanque;
use Illuminate\Database\Eloquent\Model;

class EntradaTanqueItem extends Model
{
    protected $fillable = [
        'entrada_tanque_id',
        'tanque_id',
        'quantidade',
        'valor_unitario'
    ];

    public function entrada_tanque() {
        return $this->belongsTo(EntradaTanque::class);
    }

    public function tanque() {
        return $this->belongsTo(Tanque::class);
    }
}
