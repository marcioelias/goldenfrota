<?php

namespace App\Http\Controllers;

use App\Bico;
use App\Cliente;
use App\Veiculo;
use App\Atendente;
use App\Parametro;
use App\Departamento;
use App\Abastecimento;
use App\TanqueMovimentacao;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\BicoController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\MovimentacaoCombustivelController;

class AbastecimentoController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'data_hora_abastecimento' => ['label' => 'Data/Hora', 'type' => 'datetime'],
        'valor_litro' => ['label' => 'Valor Litro', 'type' => 'decimal', 'decimais' => 3],
        'volume_abastecimento' => ['label' => 'Qtd. Abastecida', 'type' => 'decimal', 'decimais' => 2],
        'valor_abastecimento' => ['label' => 'Valor Total', 'type' => 'decimal', 'decimais' => 3], 
        'placa' => 'Veículo',
        'km_veiculo' => ['label' => 'Kilometragem', 'type' => 'decimal', 'decimais' => 1],
        'abastecimento_local' => ['label' => 'Abastecimento Local', 'type' => 'bool'],
        //'ativo' => ['label' => 'Ativo', 'type' => 'bool'],

    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        if (Auth::user()->canListarAbastecimento()) {
            $data_inicial = $request->data_inicial;
            $data_final = $request->data_final;

            if($data_inicial && $data_final) {
                $whereData = 'abastecimentos.data_hora_abastecimento between \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial.'00:00:00'), 'Y-m-d H:i:s').'\' and \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_final.'23:59:59'), 'Y-m-d H:i:s').'\'';
            } elseif ($data_inicial) {
                $whereData = 'abastecimentos.data_hora_abastecimento >= \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial.'00:00:00'), 'Y-m-d H:i:s').'\'';
            } elseif ($data_final) {
                $whereData = 'abastecimentos.data_hora_abastecimento <= \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_final.'23:59:59'), 'Y-m-d H:i:s').'\'';
            } else {
                $whereData = '1 = 1'; //busca qualquer coisa
            }
            
            if (isset($request->searchField)) {
                $abastecimentos = DB::table('abastecimentos')
                                    ->select('abastecimentos.*', 'bicos.num_bico', 'veiculos.placa', 'atendentes.nome_atendente')
                                    ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                                    ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                                    ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                                    ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                                    ->whereRaw('((abastecimentos.abastecimento_local = '.(isset($request->abast_local) ? $request->abast_local : -1).') or ('.(isset($request->abast_local) ? $request->abast_local : -1).' = -1))')
                                    ->whereRaw($whereData)
                                    ->where('veiculos.placa', 'like', '%'.$request->searchField.'%')
                                    ->orWhere('clientes.nome_razao', 'like', '%'.$request->searchField.'%')
                                    ->orderBy('abastecimentos.id', 'desc')
                                    ->paginate();
            } else {
                $abastecimentos = DB::table('abastecimentos')
                                    ->select('abastecimentos.*', 'bicos.num_bico', 'veiculos.placa', 'atendentes.nome_atendente')
                                    ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                                    ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                                    ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                                    ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                                    ->whereRaw('((abastecimentos.abastecimento_local = '.(isset($request->abast_local) ? $request->abast_local : -1).') or ('.(isset($request->abast_local) ? $request->abast_local : -1).' = -1))')
                                    ->whereRaw($whereData)
                                    ->orderBy('abastecimentos.id', 'desc')
                                    ->paginate();
            }

            return View('abastecimento.index', [
                'abastecimentos' => $abastecimentos->appends(Input::except('page')),
                'fields' => $this->fields
            ]);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->canCadastrarAbastecimento()) {
            $clientes = Cliente::where('ativo', true)->get();
            $bicos = Bico::where('permite_insercao', true)->where('ativo', true)->get();
            return View('abastecimento.create')->withClientes($clientes)->withBicos($bicos); 
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->canCadastrarAbastecimento()) {
            $this->validate($request, [
                'data_hora_abastecimento' => 'required|date_format:d/m/Y H:i:s',
                'veiculo_id' => 'required',
                'km_veiculo' => 'required|numeric|min:0',
                'volume_abastecimento' => 'required|numeric|min:0',
                'valor_litro' => 'required|numeric|min:0',
                'valor_abastecimento' => 'required|numeric|min:0'
            ]); 

            try {
                DB::beginTransaction();

                $abastecimento = new Abastecimento;
                $abastecimento->data_hora_abastecimento = \DateTime::createFromFormat('d/m/Y H:i:s', $request->data_hora_abastecimento)->format('Y-m-d H:i:s');
                $abastecimento->veiculo_id = $request->veiculo_id;
                $abastecimento->km_veiculo = $request->km_veiculo;
                $abastecimento->volume_abastecimento = str_replace(',', '.', $request->volume_abastecimento);
                $abastecimento->valor_litro = str_replace(',', '.', $request->valor_litro);
                $abastecimento->valor_abastecimento = str_replace(',', '.', $request->valor_abastecimento);
                $abastecimento->abastecimento_local = false;
                $abastecimento->bico_id = $request->bico_id;
                $abastecimento->encerrante_inicial = $request->encerrante_inicial;
                $abastecimento->encerrante_final = $request->encerrante_final;
                $abastecimento->media_veiculo = $this->obterMediaVeiculo(Veiculo::find($request->veiculo_id), $abastecimento);
                
                if ($abastecimento->save()) {


                    /* Se informado o bico, movimenta o estoque do tanque */
                    MovimentacaoCombustivelController::saidaAbastecimento($abastecimento);

                    if ($request->bico_id) {
                        if (!BicoController::atualizarEncerranteBico($request->bico_id, $request->encerrante_final)) {
                            throw new Exception(__('messages.exception', [
                                'exception' => 'Não foi possível atualizar o encerrante do bico'
                            ]));
                        }
                    }
                    
                    //Log::debug('Abastecimento Inserido: '.$abastecimento);

                    DB::commit();

                    //Ajusta médias futuras
                    if (!$this->ajustarMediaAbastecimentosFuturos($abastecimento)) {
                        throw new \Exception(__('messages.exception', [
                            'exception' => 'Não foi possível atualizar as médias futuras do veículo'
                        ]));
                    }

                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.abastecimento'),
                        'name' => $abastecimento->id
                    ]));
                    return redirect()->action('AbastecimentoController@index');
                }
            } catch (\Exception $e) {
                DB::rollback();
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return Redirect::back()->withInput(Input::all());
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Abastecimento  $abastecimento
     * @return \Illuminate\Http\Response
     */
    public function edit(Abastecimento $abastecimento)
    {
        if (Auth::user()->canAlterarAbastecimento()) {
            $abastecimento = Abastecimento::find($abastecimento->id);

            $cliente = Cliente::select('clientes.id')
                                ->leftJoin('veiculos', 'veiculos.cliente_id', 'clientes.id')
                                ->where('veiculos.id', $abastecimento->veiculo_id)
                                ->get()->first();

            $clientes = Cliente::select('clientes.*')
                                ->leftJoin('veiculos', 'veiculos.cliente_id', 'clientes.id')
                                ->where('clientes.ativo', true)
                                ->orWhere('veiculos.id', $abastecimento->veiculo_id)
                                ->distinct()
                                ->get();

            $bicos = Bico::where('ativo', true)
                                ->orWhere('id', $abastecimento->bico_id)
                                ->get();

            $veiculos = Veiculo::where('ativo', true)
                                ->orWhere('id', $abastecimento->veiculo_id)
                                ->get();

            $atendentes = Atendente::where('ativo', true)
                                ->orWhere('id', $abastecimento->atendente_id)
                                ->get();

            return View('abastecimento.edit', [
                'abastecimento' => $abastecimento,
                'clientes' => $clientes,
                'cliente' => $cliente,
                'bicos' => $bicos,
                'veiculos' => $veiculos,
                'atendentes' => $atendentes
            ]);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Abastecimento  $abastecimento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Abastecimento $abastecimento)
    {
        if (Auth::user()->canAlterarAbastecimento()) {
            $this->validate($request, [
                'data_hora_abastecimento' => 'required|date_format:d/m/Y H:i:s',
                'veiculo_id' => 'required',
                'km_veiculo' => 'required|numeric|min:0',
                'volume_abastecimento' => 'required|numeric|min:0',
                'valor_litro' => 'required|numeric|min:0',
                'valor_abastecimento' => 'required|numeric|min:0',
                'atendente_id' => 'required_with:id_automacao'
            ]); 

            try {
                $abastecimento = Abastecimento::find($abastecimento->id);
                $abastecimento->data_hora_abastecimento = \DateTime::createFromFormat('d/m/Y H:i:s', $request->data_hora_abastecimento)->format('Y-m-d H:i:s');
                $abastecimento->veiculo_id = $request->veiculo_id;
                $abastecimento->km_veiculo = $request->km_veiculo;
                $abastecimento->volume_abastecimento = str_replace(',', '.', $request->volume_abastecimento);
                $abastecimento->valor_litro = str_replace(',', '.', $request->valor_litro);
                $abastecimento->valor_abastecimento = str_replace(',', '.', $request->valor_abastecimento);
                $abastecimento->media_veiculo = $this->obterMediaVeiculo(Veiculo::find($request->veiculo_id), $abastecimento);
                $abastecimento->atendente_id = $request->atendente_id;
                $abastecimento->bico_id = $request->bico_id;
                $abastecimento->encerrante_inicial= $request->encerrante_inicial;
                $abastecimento->encerrante_final = $request->encerrante_final; 
                $abastecimento->inconsistencias_importacao = $this->existemInconsisteciasImportacao($abastecimento);

                if ($abastecimento->inconsistencias_importacao) {
                    $abastecimento->obs_abastecimento = 'Ainda existem inconsistências relacionadas a importação deste abastecimento. Verifique.';
                } else {
                    $abastecimento->obs_abastecimento = '';
                }

                if ($abastecimento->abastecimento_local) {
                    //abastecimento local tem movimentação de estoque, atualiza a movimentação
                    DB::transaction(function($dados) use($abastecimento) {
                        $movimentacao = TanqueMovimentacao::find($abastecimento->tanque_movimentacao_id);
                        $movimentacao->quantidade_combustivel = $abastecimento->volume_abastecimento;
                        $movimentacao->save();
                        $abastecimento->save();
                    });
                    Session::flash('success', 'Abastecimento '.$abastecimento->id.' alterado com sucesso.');
                    //return redirect()->action('AbastecimentoController@index');                
                } else {
                    if ($abastecimento->save()) {
                        Session::flash('success', __('messages.update_success', [
                            'model' => __('models.abastecimento'),
                            'name' => $abastecimento->id
                        ]));
                        return redirect()->action('AbastecimentoController@index');
                    }
                }
            } catch (\Exception $e) {
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return redirect()->back();
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Abastecimento  $abastecimento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Abastecimento $abastecimento)
    {
        if (Auth::user()->canExcluirAbastecimento()) {
            try {
                $abastecimento = Abastecimento::find($abastecimento->id);
                if ($abastecimento->abastecimento_local) {
                    //abastecimento local, tem movimentação de estoque. Remove a movimentação e a abastecida
                    $movimentacao = TanqueMovimentacao::find($abastecimento->tanque_movimentacao_id);
                    if ($movimentacao->delete()) {
                        Session::flash('success', __('messages.delete_success', [
                            'model' => __('models.abastecimento'),
                            'name' => $abastecimento->id
                        ]));
                        
                        return redirect()->action('AbastecimentoController@index');
                    }
                } else {
                    //abastecimento externo, não tem movimentação de estoque, por isso remove somente a abastecida
                    if ($abastecimento->delete()) {
                        Session::flash('success', __('messages.delete_success', [
                            'model' => __('models.abastecimento'),
                            'name' => $abastecimento->id
                        ]));
                        
                        return redirect()->action('AbastecimentoController@index');
                    }
                }
            } catch (\Exception $e) {
                switch ($e->getCode()) {
                    case 23000:
                        Session::flash('error', __('messages.fk_exception'));
                        break;
                    default:
                        Session::flash('error', __('messages.exception', [
                            'exception' => $e->getMessage()
                        ]));
                        break;
                }
                return redirect()->action('AbastecimentoController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    protected function existemInconsisteciasImportacao(Abastecimento $abastecimento) {
        if ($abastecimento->abastecimento_local) {
            if (!$abastecimento->bico_id) {
                return true;
            } 
            if (!$abastecimento->veiculo_id) {
                return true;
            }
            if (!$abastecimento->atendente_id) {
                return true;
            }
            if ($abastecimento->km_veiculo <= 0) {
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function obterMediaVeiculo(Veiculo $veiculo, Abastecimento $abastecimentoAtual) {
        try {
            $whereAbastAtual = 'data_hora_abastecimento < "'.$abastecimentoAtual->data_hora_abastecimento.'"';
            $abastecimento = Abastecimento::where('veiculo_id', $veiculo->id)
                            ->whereRaw($whereAbastAtual)
                            ->orderBy('data_hora_abastecimento', 'desc')->first();
            
            if (!$abastecimento) {
                //primeiro abastecimento deste veiculo;
                return 0; 
            } else {
                //veiculo já abasteceu antes
                if ($abastecimentoAtual->km_veiculo > 0) {
                    //km informada
                    return ($abastecimentoAtual->km_veiculo - $abastecimento->km_veiculo) / $abastecimentoAtual->volume_abastecimento;
                } else {
                    //km não informada
                    return 0;
                }
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function parametrosRelatorio() {
        $clientes = Cliente::all();
        $veiculos = Veiculo::select(DB::raw("concat(veiculos.placa, ' - ', marca_veiculos.marca_veiculo, ' ', modelo_veiculos.modelo_veiculo) as veiculo"), 'veiculos.id')
                                ->join('modelo_veiculos', 'modelo_veiculos.id', 'veiculos.modelo_veiculo_id')
                                ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
                                ->where('veiculos.ativo', true)
                                ->get();
        //dd($veiculos);
        return View('abastecimento.relatorio_param')->withClientes($clientes)->withVeiculos($veiculos);
    }

    public function relatorioAbastecimentos(Request $request) {

        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $parametros = array();

        if($data_inicial && $data_final) {
            $whereData = 'abastecimentos.data_hora_abastecimento between \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial.'00:00:00'), 'Y-m-d H:i:s').'\' and \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_final.'23:59:59'), 'Y-m-d H:i:s').'\'';
            array_push($parametros, 'Período de '.$data_inicial.' até '.$data_final);
        } elseif ($data_inicial) {
            $whereData = 'abastecimentos.data_hora_abastecimento >= \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial.'00:00:00'), 'Y-m-d H:i:s').'\'';
            array_push($parametros, 'A partir de '.$data_inicial);
        } elseif ($data_final) {
            $whereData = 'abastecimentos.data_hora_abastecimento <= \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_final.'23:59:59'), 'Y-m-d H:i:s').'\'';
            array_push($parametros, 'Até '.$data_final);
        } else {
            $whereData = '1 = 1'; //busca qualquer coisa
        }

        switch ($request->tipo_abastecimento) {
            case 0: 
                $whereTipoAbastecimento = ('abastecimentos.abastecimento_local = 0');
                array_push($parametros, 'Tipo de Abastecimento: Externo');
                break;
            case 1:
                $whereTipoAbastecimento = ('abastecimentos.abastecimento_local = 1');
                array_push($parametros, 'Tipo de Abastecimento: Local');
                break;
            default:
                $whereTipoAbastecimento = ('1 = 1');   
                array_push($parametros, 'Tipo de Abastecimento: Todos');
                break;
        }

        $cliente_id = $request->cliente_id;
        $departamento_id = $request->departamento_id;
        $veiculo_id = $request->veiculo_id;

        if ($veiculo_id > 0) {
            $whereParam = 'veiculos.id = '. $veiculo_id;
        } else {
            if ($departamento_id > 0) {
                $whereParam = 'veiculos.departamento_id = '. $departamento_id;
            } else {
                if ($cliente_id > 0) {
                    $whereParam = 'veiculos.cliente_id = '. $cliente_id;
                } else {
                    $whereParam = '1 = 1';
                }
            } 
        }

        if ($cliente_id > 0) {
            array_push($parametros, 'Cliente: ' . Cliente::find($cliente_id)->nome_razao);
        } 
        
        if ($departamento_id > 0) {
            array_push($parametros, 'Departamento: ' . Departamento::find($departamento_id)->departamento);
        } 

        if ($veiculo_id > 0) {
            $veiculo_param = Veiculo::select('veiculos.*', 'marca_veiculos.marca_veiculo', 'modelo_veiculos.modelo_veiculo')
                        ->join('modelo_veiculos', 'modelo_veiculos.id', 'veiculos.modelo_veiculo_id')
                        ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
                        ->where([
                            ['veiculos.id', '=', $veiculo_id]
                        ])->first();
            array_push($parametros, 'Veiculo: ' . $veiculo_param->placa . ' - ' . $veiculo_param->marca_veiculo . ' ' . $veiculo_param->modelo_veiculo);
        }

        $clientes = DB::table('abastecimentos')
                ->select('clientes.*')
                ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                ->whereRaw('clientes.id is not null')
                ->whereRaw('((abastecimentos.abastecimento_local = '.(isset($request->abast_local) ? $request->abast_local : -1).') or ('.(isset($request->abast_local) ? $request->abast_local : -1).' = -1))')
                ->whereRaw($whereData)
                ->whereRaw($whereParam)
                ->whereRaw($whereTipoAbastecimento)
                ->orderBy('clientes.nome_razao', 'asc')
                ->distinct()
                ->get();
            
        if ($request->tipo_relatorio == 1) {
            /* relatório Sintético */

            foreach($clientes as $cliente) {
                $departamentos = DB::table('abastecimentos')
                        ->select('departamentos.*')
                        ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                        ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                        ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                        ->leftJoin('clientes',         'clientes.id', 'veiculos.cliente_id')
                        ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                        ->whereRaw('clientes.id is not null')
                        ->whereRaw('((abastecimentos.abastecimento_local = '.(isset($request->abast_local) ? $request->abast_local : -1).') or ('.(isset($request->abast_local) ? $request->abast_local : -1).' = -1))')
                        ->whereRaw($whereData)
                        ->whereRaw($whereParam)
                        ->whereRaw($whereTipoAbastecimento)
                        ->where('clientes.id', $cliente->id)
                        ->orderBy('departamentos.departamento', 'asc')
                        ->distinct()
                        ->get();
                $cliente->departamentos = $departamentos;

                foreach($cliente->departamentos as $departamento) {
                    $abastecimentos = DB::table('abastecimentos')
                            ->select(
                                'veiculos.placa', 
                                DB::raw('MIN(abastecimentos.km_veiculo) AS km_inicial'),
                                DB::raw('MAX(abastecimentos.km_veiculo) AS km_final'),
                                DB::raw('SUM(abastecimentos.volume_abastecimento) AS consumo'),
                                DB::raw('AVG(abastecimentos.media_veiculo) AS media')
                            )
                            ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                            ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                            ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                            ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                            ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                            ->whereRaw('clientes.id is not null')
                            ->whereRaw('((abastecimentos.abastecimento_local = '.(isset($request->abast_local) ? $request->abast_local : -1).') or ('.(isset($request->abast_local) ? $request->abast_local : -1).' = -1))')
                            ->whereRaw($whereData)
                            ->whereRaw($whereParam)
                            ->whereRaw($whereTipoAbastecimento)
                            ->where('departamentos.id', $departamento->id)
                            ->groupBy('veiculos.placa')
                            ->get();
                            //->toSql();
                    $departamento->abastecimentos = $abastecimentos;
                }
            }
            return View('relatorios.abastecimentos.relatorio_abastecimentos')->withClientes($clientes)->withTitulo('Relatório de Abastecimentos - Sintético')->withParametros($parametros)->withParametro(Parametro::first());
        } else {
            /* relatório Analítico */
            foreach($clientes as $cliente) {
                $departamentos = DB::table('abastecimentos')
                        ->select('departamentos.*')
                        ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                        ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                        ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                        ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                        ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                        ->whereRaw('clientes.id is not null')
                        ->whereRaw('((abastecimentos.abastecimento_local = '.(isset($request->abast_local) ? $request->abast_local : -1).') or ('.(isset($request->abast_local) ? $request->abast_local : -1).' = -1))')
                        ->whereRaw($whereData)
                        ->whereRaw($whereParam)
                        ->whereRaw($whereTipoAbastecimento)
                        ->where('clientes.id', $cliente->id)
                        ->orderBy('departamentos.departamento', 'asc')
                        ->distinct()
                        ->get();
                $cliente->departamentos = $departamentos;
                foreach($cliente->departamentos as $departamento) {
                    $abastecimentos = DB::table('abastecimentos')
                            ->select('abastecimentos.*', 'veiculos.placa')
                            ->leftJoin('bicos', 'bicos.id', 'abastecimentos.bico_id')
                            ->leftJoin('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                            ->leftJoin('atendentes', 'atendentes.id', 'abastecimentos.atendente_id')
                            ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                            ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                            ->whereRaw('clientes.id is not null')
                            ->whereRaw('((abastecimentos.abastecimento_local = '.(isset($request->abast_local) ? $request->abast_local : -1).') or ('.(isset($request->abast_local) ? $request->abast_local : -1).' = -1))')
                            ->whereRaw($whereData)
                            ->whereRaw($whereParam)
                            ->whereRaw($whereTipoAbastecimento)
                            ->where('departamentos.id', $departamento->id)
                            ->orderBy('veiculos.placa', 'asc')
                            ->orderBy('abastecimentos.id', 'desc')
                            ->distinct()
                            ->get();
                    $departamento->abastecimentos = $abastecimentos;
                }
            }
             return View('relatorios.abastecimentos.relatorio_abastecimentos_analitico')->withClientes($clientes)->withTitulo('Relatório de Abastecimentos - Analítico')->withParametros($parametros)->withParametro(Parametro::first());
        }
    }


    public function relatorioAbastecimentosBicoParam() {
        $bicos = Bico::where('ativo', true)->get();

        return View('relatorios.abastecimentos.relatorio_abastecimentos_bico_param')->withBicos($bicos);
    }

    public function relatorioAbastecimentosBico(Request $request) {
       
        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $parametros = array();

        if($data_inicial && $data_final) {
            $whereData = 'abastecimentos.data_hora_abastecimento between \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial.'00:00:00'), 'Y-m-d H:i:s').'\' and \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_final.'23:59:59'), 'Y-m-d H:i:s').'\'';
            array_push($parametros, 'Período de '.$data_inicial.' até '.$data_final);
        } elseif ($data_inicial) {
            $whereData = 'abastecimentos.data_hora_abastecimento >= \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial.'00:00:00'), 'Y-m-d H:i:s').'\'';
            array_push($parametros, 'A partir de '.$data_inicial);
        } elseif ($data_final) {
            $whereData = 'abastecimentos.data_hora_abastecimento <= \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_final.'23:59:59'), 'Y-m-d H:i:s').'\'';
            array_push($parametros, 'Até '.$data_final);
        } else {
            $whereData = '1 = 1'; //busca qualquer coisa
        }

        if ($request->bico_id > 0) {
            $whereBico = 'abastecimentos.bico_id = '.$request->bico_id;
            array_push($parametros, 'Bico: '.Bico::find($request->bico_id)->num_bico);
        } else {
            $whereBico = '1 = 1';
        }

        $bicos = DB::table('abastecimentos')
                        ->select('bicos.id', 'bicos.num_bico', 'tanques.descricao_tanque', 'combustiveis.descricao')    
                        ->join('bicos', 'bicos.id', 'abastecimentos.bico_id')
                        ->join('tanques', 'tanques.id', 'bicos.tanque_id')
                        ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                        ->whereRaw($whereData)
                        ->whereRaw($whereBico)
                        ->distinct()
                        ->orderBy('bicos.num_bico', 'asc')
                        ->get();

        foreach ($bicos as $bico) {
            $bico->abastecimentos = DB::table('abastecimentos')
                                            ->select('abastecimentos.*', 'veiculos.placa')
                                            ->join('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                                            ->where('abastecimentos.bico_id', '=', $bico->id)
                                            ->whereRaw($whereData)
                                            ->orderBy('abastecimentos.id', 'asc')
                                            ->get();
        }       

        return View('relatorios.abastecimentos.relatorio_abastecimentos_bico')
                    ->withBicos($bicos)
                    ->withParametros($parametros)
                    ->withTitulo('Relatório de Abastecimentos - Bicos')
                    ->withParametro(Parametro::first());
    }

    function ajustarMediaAbastecimentosFuturos(Abastecimento $abastecimento) {
        try {
            $abastFuturos = Abastecimento::where('veiculo_id', $abastecimento->veiculo_id)
                            ->where('data_hora_abastecimento', '>', $abastecimento->data_hora_abastecimento)
                            ->orderBy('data_hora_abastecimento', 'asc')->get();

            $veiculo = Veiculo::find($abastecimento->veiculo_id);

            DB::beginTransaction();
            foreach ($abastFuturos as $abastFuturo) {    
                $abastFuturo->media_veiculo = $this->obterMediaVeiculo($veiculo, $abastFuturo);
                $abastFuturo->save();
            }

            DB::commit();

            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }
}