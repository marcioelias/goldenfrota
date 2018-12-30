<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Estoque;
use App\Produto;
use App\Parametro;
use App\SaidaEstoque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MovimentacaoProdutoController;

class SaidaEstoqueController extends Controller
{
    public $fields = [
        'id' => 'ID',
        'nome_cliente' => 'Cliente',
        'data_saida' => [
            'label' => 'Data',
            'type' => 'datetime'
        ],
        'valor_total' => [
            'label' => 'Valor',
            'type' => 'decimal',
            'decimais' => 3
        ]
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarSaidaEstoque()) {
            if ($request->searchField) {
                $saidas = DB::table('saida_estoques')
                                    ->select('saida_estoques.*', 'clientes.nome_razao as nome_cliente')
                                    ->leftJoin('clientes', 'clientes.id', 'saida_estoques.cliente_id')
                                    ->where('clientes.nome_razao', 'like', '%'.$request->searchField.'%')
                                    ->orWhere('clientes.fantasia', 'like', '%'.$request->searchField.'%')
                                    ->orderBy('id', 'desc')
                                    ->paginate();
            } else {
                $saidas = DB::table('saida_estoques')
                                    ->select('saida_estoques.*', 'clientes.nome_razao as nome_cliente')
                                    ->leftJoin('clientes', 'clientes.id', 'saida_estoques.cliente_id')
                                    ->orderBy('id', 'desc')
                                    ->paginate();
            }

            return View('saida_estoque.index', [
                'fields' => $this->fields,
                'saidas' => $saidas
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
        if (Auth::user()->canCadastrarSaidaEstoque()) {
            return View('saida_estoque.create', [
                'clientes' => Cliente::where('ativo', true)->get(),
                'estoques' => Estoque::where('ativo', true)->get(),
                //'produtos' => Produto::where('ativo', true)->get()
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

        if (Auth::user()->canCadastrarSaidaEstoque()) {
            $this->validate($request, [
                'cliente_id' => 'required',
                'estoque_id' => 'required|integer',
                'data_saida' => 'required',
                'items' => 'required|array|min:1'
            ]);

            try {                
                $dataSaida = \DateTime::createFromFormat('d/m/Y H:i', $request->data_saida);

                DB::beginTransaction();
    
                $saidaEstoque = new SaidaEstoque($request->all());
                $saidaEstoque->data_saida = $dataSaida->format('Y-m-d H:i:s');

                if ($saidaEstoque->save()) {
                    $saidaEstoque->saida_estoque_items()->createMany($request->items);

                    //falta a movimentação de estoque!!!
                    MovimentacaoProdutoController::saidaEstoque($saidaEstoque);


                    DB::commit();
                    Session::flash('success', __('messages.create_success_f', [
                        'model' => 'saida_estoque', 
                        'name' => $saidaEstoque->id
                    ]));

                    return redirect()->action('SaidaEstoqueController@index');
                } else {
                    Session::flash('error', __('messages.create_error_f', [
                        'model' => 'saida_estoque',
                        'name' => $saidaEstoque->id
                    ]));
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
     * Display the specified resource.
     *
     * @param  \App\SaidaEstoque  $saidaEstoque
     * @return \Illuminate\Http\Response
     */
    public function show(SaidaEstoque $saidaEstoque)
    {
        if (Auth::user()->canListarSaidaEstoque()) {
            return View('saida_estoque.show')
                    ->withSaidaEstoque($saidaEstoque)
                    ->withTitulo('Saída de Estoque')
                    //->withParametros($parametros)
                    ->withParametro(Parametro::first());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaidaEstoque  $saidaEstoque
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaidaEstoque $saidaEstoque)
    {
        if (Auth::user()->canExcluirSaidaEstoque()) {
            try {
                $saidaEstoque = SaidaEstoque::find($saidaEstoque->id);
                if ($saidaEstoque->delete()) {
                    Session::flash('success', __('messages.delete_success_f', [
                        'model' => __('models.saida_estoque'),
                        'name' => $saidaEstoque->id 
                    ]));
                    return redirect()->action('SaidaEstoqueController@index');
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
                return redirect()->action('SaidaEstoqueController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }
}
