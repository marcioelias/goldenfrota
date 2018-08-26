<?php

namespace App\Http\Controllers;

use App\User;
use App\Cliente;
use App\Estoque;
use App\Produto;
use App\Servico;
use App\Parametro;
use App\OrdemServico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrdemServicoController extends Controller
{
    public $fields = [
        'id' => 'ID',
        'nome_razao' => 'Cliente',
        'placa' => 'Veículo',
        'name' => 'Usuário',
        'created_at' => ['label' => 'Data', 'type' => 'datetime'],
        'fechada' => ['label' => 'Fechada', 'type' => 'bool']
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
                                ->select('ordem_servicos.*', 'clientes.nome_razao', 'veiculos.placa', 'users.name')
                                ->leftJoin('veiculos', 'veiculos.id', 'ordem_servicos.veiculo_id')
                                ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                                ->leftJoin('users', 'users.id', 'ordem_servicos.user_id')
                                ->where('clientes.nome_razao', 'like', '%'.$request->searchField.'%')
                                ->orWhere('veiculos.placa', 'like', '%'.$request->searchField.'%')
                                ->orderBy('id', 'desc')
                                ->paginate();
            } else {
                $ordemServicos = DB::table('ordem_servicos')
                                ->select('ordem_servicos.*', 'clientes.nome_razao', 'veiculos.placa', 'users.name')
                                ->leftJoin('veiculos', 'veiculos.id', 'ordem_servicos.veiculo_id')
                                ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                                ->leftJoin('users', 'users.id', 'ordem_servicos.user_id')
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

            return View('ordem_servico.create', [
                'clientes' => $clientes,
                'estoques' => $estoques,
                'servicos' => $servicos,
                'produtos' => $produtos
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
        if (Auth::user()->canCadastrarOrdemServico()) {
            try {
                /* $this->validate($request, [
                    'cliente_id' => 'required',
                    'veidulo_id' => 'required',
                    'km_veiculo' => 'required',
                    //'servicos' => 'array|size:1',
                ]); */

                DB::beginTransaction();

                $ordemServico = Auth::user()->ordem_servico()->create($request->all());
                
                if (is_array($request->servicos)) {
                    $ordemServico->servicos()->createMany($request->servicos);
                }

                if (is_array($request->produtos)) {
                    $ordemServico->produtos()->createMany($request->produtos);
                }

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrdemServico  $ordemServico
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrdemServico $ordemServico)
    {
        //
    }
}
