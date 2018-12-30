<?php

namespace App;

use App\Produto;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    public $fillable = ['unidade', 'permite_fracionamento', 'ativo'];

    public function produtos() {
        return $this->hasMany(Produto::class);
    }
}
