<?php

namespace App\Listeners;

use App\Events\NovoRegistroAtualizacaoApp;
use Illuminate\Support\Facades\Log;
use App\AtualizacaoApp;
use Illuminate\Support\Facades\App;

class ExportaDadosApp
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
     * @param  NovoRegistroAtualizacaoApp  $event
     * @return void
     */
    public function handle(NovoRegistroAtualizacaoApp $event)
    {
        try {

            $keyName = $event->registro->getKeyName();

            $atualizacaoApp = new AtualizacaoApp([
                'tabela' => $event->registro->getTable(),
                'chave' => $event->registro->$keyName,
                'remover' => $event->exclusao
            ]);

            if (App::environment('local')) {
                log::debug($atualizacaoApp);
            }
         
            $atualizacaoApp->save();

        } catch (\Exception $e) {
            log::error('Erro ao gerar atualização para APP: ' + $e->getMessage());
        }
    }
}
