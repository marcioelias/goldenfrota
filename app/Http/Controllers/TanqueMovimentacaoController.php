<?php

namespace App\Http\Controllers;

use App\Combustivel;
use App\TanqueMovimentacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TanqueMovimentacaoController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'data_movimentacao' => ['label' => 'Data Entrada', 'type' => 'date'],
        'documento' => 'Documento',
        'descricao_tanque' => 'Tanque',
        'descricao' => 'Combustivel',
        'quantidade_combustivel' => 'Quantidade',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
         $this->middleware('auth');
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->searchField)) {
            $movimentacoes = DB::table('tanque_movimentacoes')
                                ->select('tanque_movimentacoes.*', 'tanques.descricao_tanque', 'combustiveis.descricao')
                                ->join('tanques', 'tanques.id', 'tanque_movimentacoes.tanque_id')
                                ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                                ->where([
                                    ['data_hora_abastecimento', '=', $request->searchField],
                                    ['entrada_combustivel', true]
                                ])
                                ->paginate();
        } else {
            $movimentacoes = DB::table('tanque_movimentacoes')
                                ->select('tanque_movimentacoes.*', 'tanques.descricao_tanque', 'combustiveis.descricao' )
                                ->join('tanques', 'tanques.id', 'tanque_movimentacoes.tanque_id')
                                ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                                ->where('entrada_combustivel', true)
                                ->paginate();
        }

        return View('tanque_movimentacao.index', [
            'movimentacoes' => $movimentacoes,
            'fields' => $this->fields
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $combustiveis = Combustivel::where('ativo', true)->get();

        return View('tanque_movimentacao.create')->withCombustiveis($combustiveis);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'data_movimentacao' => 'required',
            'tanque_id' => 'required',
            'quantidade_combustivel' => 'required'
        ]);

        try {
            $movimentacao = new TanqueMovimentacao;
            $movimentacao->data_movimentacao = \DateTime::createFromFormat('d/m/Y', $request->data_movimentacao)->format('Y-m-d');
            $movimentacao->documento = $request->documento;
            $movimentacao->tanque_id = $request->tanque_id;
            $movimentacao->quantidade_combustivel = $request->quantidade_combustivel;
            $movimentacao->entrada_combustivel = true;


            if ($movimentacao->save()) {
                Session::flash('success', 'Entrada de Combustível '.$movimentacao->documento.' cadastrada com sucesso.');
                return redirect()->action('TanqueMovimentacaoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('tanque_movimentacao.create', [
                'combustiveis' => Combustivel::where('ativo', true)->get()
            ]); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TanqueMovimentacao  $tanqueMovimentacao
     * @return \Illuminate\Http\Response
     */
    public function show(TanqueMovimentacao $tanqueMovimentacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TanqueMovimentacao  $tanqueMovimentacao
     * @return \Illuminate\Http\Response
     */
    public function edit(TanqueMovimentacao $tanqueMovimentacao)
    {
        $movimentacao = TanqueMovimentacao::select('tanque_movimentacoes.*', 'combustiveis.id')
                                    ->join('tanques', 'tanques.id', 'tanque_movimentacoes.tanque_id')
                                    ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                                    ->where('tanque_movimentacoes.id', $tanqueMovimentacao->id)
                                    ->first();        

        $combustiveis = Combustivel::select('combustiveis.*')
                                    ->join('tanques', 'tanques.combustivel_id', 'combustiveis.id')
                                    ->where('combustiveis.ativo', true)
                                    ->orWhere('tanques.id', $movimentacao->tanque_id)
                                    ->get();

        return View('tanque_movimentacao.edit')->withMovimentacao($movimentacao)->withCombustiveis($combustiveis);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TanqueMovimentacao  $tanqueMovimentacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TanqueMovimentacao $tanqueMovimentacao)
    {
        $this->validate($request, [
            'data_movimentacao' => 'required',
            'tanque_id' => 'required',
            'quantidade_combustivel' => 'required'
        ]);

        try {
            $movimentacao = TanqueMovimentacao::find($tanqueMovimentacao->id);
            $movimentacao->data_movimentacao = \DateTime::createFromFormat('d/m/Y', $request->data_movimentacao)->format('Y-m-d');
            $movimentacao->documento = $request->documento;
            $movimentacao->tanque_id = $request->tanque_id;
            $movimentacao->quantidade_combustivel = $request->quantidade_combustivel;
            $movimentacao->entrada_combustivel = true;
            $movimentacao->ativo = $request->ativo;


            if ($movimentacao->save()) {
                Session::flash('success', 'Entrada de Combustível '.$movimentacao->documento.' alterada com sucesso.');
                return redirect()->action('TanqueMovimentacaoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('tanque_movimentacao.create', [
                'combustiveis' => Combustivel::where('ativo', true)->get()
            ]); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TanqueMovimentacao  $tanqueMovimentacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(TanqueMovimentacao $tanqueMovimentacao)
    {
        try {
            $tanqueMovimentacao = TanqueMovimentacao::find($tanqueMovimentacao->id);
            if ($tanqueMovimentacao->delete()) {
                Session::flash('success', 'Entrada de Combustível '.$tanqueMovimentacao->id.' removido com sucesso.');
                
                return redirect()->action('TanqueMovimentacaoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Registro não pode ser excluído. '.$e->getMessage());
            return redirect()->action('TanqueMovimentacaoController@index');
        }
    }
}
