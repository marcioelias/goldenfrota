<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdemServicoStatus extends Model
{
    protected $table = 'ordem_servico_status';

    protected $fillable = [
        'os_status',
        'em_aberto'
    ];
}
