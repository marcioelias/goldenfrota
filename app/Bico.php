<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bico extends Model
{
    public $fillable = ['num_bico', 'tanque_id', 'bomba_id', 'encerrante', 'ativo'];
}
