<?php

namespace App\Listeners;

use App\Events\AlteracaoKmVeiculo;
use App\Veiculo;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AtualizarKmveiculo
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AlteracaoKmVeiculo  $event
     * @return void
     */
    public function handle(AlteracaoKmVeiculo $event)
    {
        $veiculo = $event->veiculo;
        $veiculo->hodometro = $event->kmAtualizado;
        $veiculo->save();
    }
}
