<?php

namespace App\Listeners;

use App\Produto;
use App\VencimentoProduto;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\UtilizadoProdutoControleVencimento;

class RegistraVencimentoProdutoUtilizado
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
     * @param  UtilizadoProdutoControleVencimento  $event
     * @return void
     */
    public function handle(UtilizadoProdutoControleVencimento $event)
    {
        $fatorVencimento = 0;
        /* percorre todos os produtos da OS */
        foreach($event->ordemServico->produtos as $produtoOs) {
            $produto = Produto::find($produtoOs->produto_id);
            /* verifica se o produto controla vencimento */
            if ($produto->controla_vencimento) {
                /* verifica o tipo de controle do veiculo (KM Precorridos/Horas Trabalhadas) */
                if ($event->ordemServico->veiculo->tipo_controle_veiculo_id == 1) {
                    /* vencimento por km Percorridos */
                    $fatorVencimento = $event->ordemServico->km_veiculo + $produto->vencimento_km;
                } else {
                    /* vencimento por Horas trabalhadas */
                    $fatorVencimento = $event->ordemServico->km_veiculo + $produto->vencimento_horas_trabalhadas;
                }

                $vencimento = VencimentoProduto::updateOrCreate(
                    [
                        'ordem_servico_id' => $event->ordemServico->id,
                        'veiculo_id' => $event->ordemServico->veiculo_id,
                        'produto_id' => $produto->id
                    ],
                    [
                        'data_proxima_troca' => Carbon::now()->addDays($produto->vencimento_dias),
                        'proxima_troca_km_horas' => $fatorVencimento
                    ]
                );
                
                $fatorVencimento = 0;
            }
        }
    }
}
