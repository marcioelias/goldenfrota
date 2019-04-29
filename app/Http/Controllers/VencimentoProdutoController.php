<?php

namespace App\Http\Controllers;

use App\Veiculo;
use App\GroupSetting;
use App\Abastecimento;
use App\VencimentoProduto;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class VencimentoProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Verifica o vencimento de todos os produtos associados a veículos
     */
    public function verificarVencimentoProdutos() {
        $this->processarVerificacaoProdutosNaoVencidos(
                VencimentoProduto::TrocaNaoEfetuada()->get(), 
                $this->obterConfiguracaoNotificacao()
        );
    }

    /**
     * Obtem a configuração de notificação de produtos antes do vencimento
     *
     * @return Array
     */
    public function obterConfiguracaoNotificacao() {
        $configs = GroupSetting::ConfigNotificacaoVencimento()->with('settings')->first()->settings;
        $result = array();
        
        foreach($configs as $config) {
            $result[$config->key] = $config->value;
        }

        return $result;
    }

    /**
     * Processa a verificação de todos os produtos não vencidos, atribuindo status de vencido ou próximo do vencimento
     * de acordo com as configurações do produto e também do sistema (para controle de notificações de proximidade
     * do vencimento).
     *
     * @param Collection $produtos
     * @param array $configuracaoNotificacao
     * @return void
     */
    public function processarVerificacaoProdutosNaoVencidos(Collection $produtos, array $configuracaoNotificacao) {
        foreach ($produtos as $produto) {
            if ($this->produtoEstaVencido($produto)) {
                /* produto não vencido */
                $this->notificarProdutoVencido($produto);
            } else {
                /* produto vencido */
                if ($this->produtoEstaProximoDoVencimento($produto, $configuracaoNotificacao)) {
                    /* produto está próximo de vencer */
                    $this->notificarProdutoProximoDoVencimento($produto);
                }
            }
        }
    }

    /**
     * Retorna verdadeiro caso o a instancia de VencimentoProduto informada
     * já tenha expirado sua data máxima de validade, caso contrário retorna falso.
     *
     * @param VencimentoProduto $produto
     * @return Boolean
     */
    public function produtoEstaVencido(VencimentoProduto $produto) {
        return (($this->obterOdometroHorimetroAtual($produto->veiculo) >= $produto->proxima_troca_km_horas) ||
                $produto->data_proxima_troca->isPast());
        
    }

    /**
     * Retorna verdadeiro se o modelo atribuido a instância do veículo informada
     * empregar o controle por Km Rodados. Caso o controle seja por Horas Trabalhadas
     * retora falso.
     *
     * @param Veiculo $veiculo
     * @return Boolean
     */
    public function veiculoControladoPorKm(Veiculo $veiculo) {
        return ($veiculo->modelo_veiculo->controlePorKmRodados());
    }

    public function notificarProdutoProximoDoVencimento(VencimentoProduto $produto) {
        $produto->proximo_vencer = true;
        $produto->save();
    }

    public function notificarProdutoVencido(VencimentoProduto $produto) {
        $produto->proximo_vencer = false;
        $produto->vencido = true;
        $produto->save();
    }

    public function produtoEstaProximoDoVencimento(VencimentoProduto $produto, array $configuracaoNotificacao) {
        return $this->produtoEstaProximoDataVencimento($produto, $configuracaoNotificacao['notification_product_days']) ||
            $this->produtoEstaProximoKmVencimento($produto, $configuracaoNotificacao['notification_product_km']) ||
            $this->produtoEstaProximoHorasVencimento($produto, $configuracaoNotificacao['notification_product_hours']);
    }

    public function produtoEstaProximoDataVencimento(VencimentoProduto $produto, Int $numeroDiasNotificacao) {
        return (Carbon::now()->diffInDays($produto->data_proxima_troca) <= $numeroDiasNotificacao);
    }

    public function produtoEstaProximoKmVencimento(VencimentoProduto $produto, Int $numeroKmNotificacao) {
        return ($produto->proxima_troca_km_horas - $this->obterOdometroHorimetroAtual($produto->veiculo)) <= $numeroKmNotificacao;
    }

    public function produtoEstaProximoHorasVencimento(VencimentoProduto $produto, Int $numeroHorasNotificacao) {
        return ($produto->proxima_troca_km_horas - $this->obterOdometroHorimetroAtual($produto->veiculo)) <= $numeroHorasNotificacao;
    }

    public function obterOdometroHorimetroAtual(Veiculo $veiculo) {
        return Abastecimento::UltimoDoVeiculo($veiculo->id)->km_veiculo;
    }

    public function getProdutosVencendoVencidosPorVeiculo(Veiculo $veiculo) {
        return response()->json(VencimentoProduto::ProximoDoVencimentoOuVencido($veiculo)->with('produto')->get());
    }
}
