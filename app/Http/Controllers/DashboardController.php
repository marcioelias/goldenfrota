<?php

namespace App\Http\Controllers;

use App\Tanque;
use Illuminate\Http\Request;
use ConsoleTVs\Charts\Facades\Charts;
use App\Http\Controllers\TanqueMovimentacaoController;

class DashboardController extends Controller
{
    public function index() {
        return View('teste', [
            'tanques' => $this->movimentacaoCombustiveis()
        ]);
    }

    public function movTanque($tanque_id) {
        $dataFinal = new \DateTime();
        $dataInicial = new \Datetime();
        $dataInicial->sub(new \DateInterval('P15D'));
        $tanque = Tanque::find($tanque_id);
        $grafico = array();
        while ($dataInicial < $dataFinal) {
            $grafico['labels'][] = $dataInicial->format('d/m/Y');
            $grafico['datasets'][0]['label'] = $tanque->descricao_tanque.' - '.$tanque->combustivel->descricao;
            $grafico['datasets'][0]['backgroundColor'] =  'rgba(45, 195, 21, 0.2)'; //'#CCFF66';
            $grafico['datasets'][0]['data'][] = (new TanqueMovimentacaoController)->getPosicaoTanque($tanque, $dataInicial);
            $dataInicial->add(new \DateInterval('P1D'));
        }

        return response()->json($grafico);
    }

    public function movimentacaoCombustiveis() {
        $tanques = Tanque::where('ativo', true)->get();
        $dataFinal = new \DateTime();
        $dataInicial = new \Datetime();
        $dataInicial->sub(new \DateInterval('P30D'));
        $graficos = array();
        foreach ($tanques as $tanque) {
            $labels = array();
            $values = array();
            while ($dataInicial < $dataFinal) {
                $labels[] = $dataInicial->format('d/m/Y');
                $values[] = (new TanqueMovimentacaoController)->getPosicaoTanque($tanque, $dataInicial);
                $dataInicial->add(new \DateInterval('P1D'));
            }
            $graficos[$tanque->id][] = Charts::create('area', 'highcharts')
                                ->title('Tanque '.$tanque->id.': '.$tanque->combustivel->descricao)
                                ->elementLabel('Posição')
                                ->labels($labels)
                                ->values($values)
                                ->responsive(true);
        }

        return $graficos;
    }
}
