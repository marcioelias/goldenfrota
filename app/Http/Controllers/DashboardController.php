<?php

namespace App\Http\Controllers;

use App\Tanque;
use App\Veiculo;
use App\Abastecimento;
use Illuminate\Http\Request;
use App\MovimentacaoCombustivel;
use Illuminate\Support\Facades\DB;
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
        while ($dataInicial <= $dataFinal) {
            $grafico['labels'][] = $dataInicial->format('d/m');
            $grafico['datasets'][0]['label'] = $tanque->descricao_tanque.' - '.$tanque->combustivel->descricao;
            $grafico['datasets'][0]['backgroundColor'] =  'rgba(45, 195, 21, 0.2)';
            $grafico['datasets'][0]['data'][] = (new TanqueMovimentacaoController)->getPosicaoTanque($tanque, $dataInicial);
            $dataInicial->add(new \DateInterval('P1D'));
        }

        if ($dataInicial > $dataFinal) {
            $grafico['labels'][] = $dataFinal->format('d/m');
            $grafico['datasets'][0]['label'] = $tanque->descricao_tanque.' - '.$tanque->combustivel->descricao;
            $grafico['datasets'][0]['backgroundColor'] =  'rgba(45, 195, 21, 0.2)';
            $grafico['datasets'][0]['data'][] = (new TanqueMovimentacaoController)->getPosicaoTanque($tanque, $dataFinal);
        }

        return response()->json($grafico);
    }

    public function ultimasEntradasComb() {
        $entradas = DB::table('movimentacao_combustiveis')
                        ->select('movimentacao_combustiveis.*', 'tanques.descricao_tanque', 'combustiveis.descricao', 'entrada_tanques.nr_docto', 'entrada_tanques.serie', 'entrada_tanques.data_entrada')
                        ->join('tipo_movimentacao_combustiveis', 'tipo_movimentacao_combustiveis.id', 'movimentacao_combustiveis.tipo_movimentacao_combustivel_id')
                        ->join('tanques', 'tanques.id', 'movimentacao_combustiveis.tanque_id')
                        ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                        ->join('entrada_tanques', 'entrada_tanques.id', 'movimentacao_combustiveis.entrada_tanque_id')
                        ->where('tipo_movimentacao_combustiveis.eh_entrada', true)
                        ->orderBy('movimentacao_combustiveis.created_at', 'desc')
                        ->take(5)
                        ->get();

        return response()->json($entradas);
    }

    public function totalVeiculosFrota() {
        $veiculos['total_veiculos_frota'] = Veiculo::where('ativo', true)->count();

        return response()->json($veiculos);
    }

    public function abastecimentosHoje() {
        $data = new \Datetime();

        $abastecimentos['abastecimentos_hoje'] = Abastecimento::whereDate('data_hora_abastecimento', $data->format('Y-m-d'))->count();

        return response()->json($abastecimentos);
    }

    /* public function produtosAbaixoEstoqueMinimo() {
        $produtos = DB::table('produtos')
                ->select('produtos.*', 'estoques.estoque', )
    } */
}
