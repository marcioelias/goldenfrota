<?php

namespace App;

use App\Produto;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    public $fillable = ['estoque', 'ativo'];

    public function produtos() {
        return $this->belongsToMany(Produto::class);
    }
}
