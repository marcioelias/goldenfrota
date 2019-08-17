<?php

namespace App\Listeners;

use App\Veiculo;
use App\VencimentoProduto;
use App\Events\NovoAbastecimento;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfereVencimentoProdutos
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
     * @param  NovoAbastecimento  $event
     * @return void
     */
    public function handle(NovoAbastecimento $event)
    {
        
    }
}
