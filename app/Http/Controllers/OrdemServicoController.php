<?php

namespace App\Http\Controllers;

use App\User;
use App\Cliente;
use App\Estoque;
use App\Produto;
use App\Servico;
use App\Parametro;
use App\OrdemServico;
use App\OrdemServicoStatus;
use App\MovimentacaoProduto;
use App\OrdemServicoProduto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MovimentacaoProdutoController;

class OrdemServicoController extends Controller
{
    public $fields = [
        'id' => 'ID',
        'nome_razao' => 'Cliente',
        'placa' => 'Veículo',
        'name' => 'Usuário',
        'created_at' => ['label' => 'Data', 'type' => 'datetime'],
        'os_status' => 'Status'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarOrdemServico()) {
            if ($request->searchField) {
                $ordemServicos = DB::table('ordem_servicos')
                                ->select('ordem_servicos.*', 'clientes.nome_razao', 'veiculos.placa', 'users.name', 'ordem_servico_status.os_status')
                                ->leftJoin('veiculos', 'veiculos.id', 'ordem_servicos.veiculo_id')
                                ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                                ->leftJoin('users', 'users.id', 'ordem_servicos.user_id')
                                ->leftJoin('ordem_servico_status', 'ordem_servico_status.id', 'ordem_servico_status_id')
                                ->where('clientes.nome_razao', 'like', '%'.$request->searchField.'%')
                                ->orWhere('veiculos.placa', 'like', '%'.$request->searchField.'%')
                                ->orderBy('id', 'desc')
                                ->paginate();
            } else {
                $ordemServicos = DB::table('ordem_servicos')
                                ->select('ordem_servicos.*', 'clientes.nome_razao', 'veiculos.placa', 'users.name', 'ordem_servico_status.os_status')
                                ->leftJoin('veiculos', 'veiculos.id', 'ordem_servicos.veiculo_id')
                                ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                                ->leftJoin('users', 'users.id', 'ordem_servicos.user_id')
                                ->leftJoin('ordem_servico_status', 'ordem_servico_status.id', 'ordem_servico_status_id')
                                ->orderBy('id', 'desc')
                                ->paginate();
            }

            return View('ordem_servico.index', [
                'ordem_servicos' => $ordemServicos,
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
        if (Auth::user()->canCadastrarOrdemServico()) {
            $clientes = Cliente::where('ativo', true)->orderBy('nome_razao', 'asc')->get();
            $estoques = Estoque::where('ativo', true)->orderBy('estoque', 'asc')->get();
            $servicos = Servico::where('ativo', true)->orderBy('servico', 'asc')->get();
            $produtos = Produto::where('ativo', true)->orderBy('produto_descricao', 'asc')->get();
            $ordemServicoStatus = OrdemServicoStatus::orderBy('os_status', 'asc')->get();

            return View('ordem_servico.create', [
                'clientes' => $clientes,
                'estoques' => $estoques,
                'servicos' => $servicos,
                'produtos' => $produtos,
                'ordemServicoStatus' => $ordemServicoStatus
            ]);
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
        //dd($request->all());
        //return redirect()->back()->withInput();
        //dd(Estoque::find($request->estoque_id));
        if (Auth::user()->canCadastrarOrdemServico()) {
            $this->validate($request, [
                'cliente_id' => 'required',
                'veiculo_id' => 'required',
                'km_veiculo' => 'required|numeric|min:0',
                //'servicos' => 'array|size:1',
            ]);
            try {

                DB::beginTransaction();

                $ordemServico = Auth::user()->ordem_servico()->create($request->all());

                $osStatus = OrdemServicoStatus::find($ordemServico->ordem_servico_status_id);
                if (!$osStatus->em_aberto) {
                    $ordemServico->data_fechamento = date('Y-m-d H:i:s');
                }
                
                if (is_array($request->servicos)) {
                    $ordemServico->servicos()->createMany($request->servicos);
                }

                if (is_array($request->produtos)) {
                    $ordemServico->produtos()->createMany($request->produtos);
                }

                MovimentacaoProdutoController::saidaOrdemServico($ordemServico);

                DB::commit();

                Session::flash('success', __('messages.create_success_f', [
                    'model' => __('models.ordem_servico'),
                    'name' => 'Ordem de Serviço'
                ]));

                return redirect()->action('OrdemServicoController@index');
                
            } catch (\Exception $e) {
                DB::rollback();
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return redirect()->back()->withInput();
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrdemServico  $ordemServico
     * @return \Illuminate\Http\Response
     */
    public function show(OrdemServico $ordemServico)
    {
        if (Auth::user()->canListarOrdemServico()) {
            return View('ordem_servico.show')
                    ->withOrdemServico($ordemServico)
                    ->withTitulo('Ordem de Serviço')
                    //->withParametros($parametros)
                    ->withParametro(Parametro::first());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrdemServico  $ordemServico
     * @return \Illuminate\Http\Response
     */
    public function edit(OrdemServico $ordemServico)
    {
        if (Auth::user()->canAlterarOrdemServico()) {

            /* Não permite alterar OS Fechada */
            $osStatus = OrdemServicoStatus::find($ordemServico->ordem_servico_status_id);
            if (!$osStatus->em_aberto) {
                Session::flash('error', __('messages.edit_not_allowed', [
                    'model' => __('models.ordem_servico'),
                    'status' => __('strings.os_status_fechada')
                ]));
                return redirect()->back();
            }

            
            $servicos = Servico::where('ativo', true)->orderBy('servico', 'asc')->get();
            $produtos = Produto::where('ativo', true)->orderBy('produto_descricao', 'asc')->get(); 
            $estoques = Estoque::where('ativo', true)->orderBy('estoque', 'asc')->get();
            $veiculos = $ordemServico->veiculo->get();
            $clientes = $ordemServico->veiculo->cliente->get();
            $ordemServicoStatus = OrdemServicoStatus::orderBy('os_status', 'asc')->get();

            return View('ordem_servico.edit', [
                'veiculos' => $veiculos,
                'ordemServico' => $ordemServico,
                'estoques' => $estoques,
                'servicos' => $servicos,
                'produtos' => $produtos,
                'ordemServicoStatus' => $ordemServicoStatus
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
     * @param  \App\OrdemServico  $ordemServico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrdemServico $ordemServico)
    {
        if (Auth::user()->canAlterarOrdemServico()) {
            $this->validate($request, [
                'cliente_id' => 'required',
                'veiculo_id' => 'required',
                'km_veiculo' => 'required|numeric|min:0',
                //'servicos' => 'array|size:1',
            ]);
            try {
                DB::beginTransaction();

                $ordemServico->fill($request->all());

                $osStatus = OrdemServicoStatus::find($ordemServico->ordem_servico_status_id);
                if (!$osStatus->em_aberto) {
                    $ordemServico->data_fechamento = date('Y-m-d H:i:s');
                }

                if ($ordemServico->save()) {
                    /* remove produtos */
                    $ordemServico->produtos()->delete();

                    /* remove serviços */
                    $ordemServico->servicos()->delete();

                    /* inclui produtos */
                    if (is_array($request->produtos)) {
                        $ordemServico->produtos()->createMany($request->produtos);
                    }

                    /* inclui serviços */
                    if (is_array($request->servicos)) {
                        $ordemServico->servicos()->createMany($request->servicos);
                    }

                    /* movimenta o estoque dos produtos */
                    MovimentacaoProdutoController::saidaOrdemServico($ordemServico);

                    /* comita a transação */
                    DB::commit();

                    Session::flash('success', __('messages.update_success_f', [
                        'model' => __('models.ordem_servico'),
                        'name' => $ordemServico->id
                    ]));
    
                    return redirect()->action('OrdemServicoController@index');
                } else {
                    DB::rollback();
                    
                    Session::flash('error', __('messages.update_error_f', [
                        'model' => __('models.ordem_servico'),
                        'name' => $ordemServico->id
                    ]));

                    return redirect()->back()->withInput();
                }            
            } catch (\Exception $e) {
                DB::rollback();
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage() 
                ]));
                return redirect()->back()->withInput();  
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrdemServico  $ordemServico
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrdemServico $ordemServico)
    {
        if (Auth::user()->canExcluirOrdemServico()) {   
            try {
                if ($ordemServico->delete()) {
                    Session::flash('success', __('messages.delete_success_f', [
                        'model' => __('models.ordem_servico'),
                        'name' => $ordemServico->id
                    ]));
                    return redirect()->action('OrdemServicoController@index');
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
                return redirect()->action('OrdemServicoController@index');        
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }
}
