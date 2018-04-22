<?php

namespace App\Http\Controllers;

use App\Tanque;
use App\Parametro;
use App\Combustivel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Support\Facades\Session;

class TanqueController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'descricao_tanque' => 'Tanque',
        'descricao' => 'Combustivel',
        'capacidade' => 'Capacidade',
        'posicao' => 'Posição Atual',
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
            $tanques = DB::table('tanques')
                            ->select('tanques.*', 'combustiveis.descricao')
                            ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                            ->where('descricao_tanque', 'like', '%'.$request->searchField.'%')
                            ->paginate();
        } else {
            $tanques = DB::table('tanques')
                            ->select('tanques.*', 'combustiveis.descricao')
                            ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                            ->paginate();
        }


       /*  if (isset($request->searchField)) {
            $tanques = Tanque::where('descricao_tanque', 'like', '%'.$request->searchField.'%')->paginate();
        } else {
            $tanques = Tanque::paginate();
        } */

        return View('tanque.index')->withTanques($tanques)->withFields($this->fields);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $combustiveis = Combustivel::all();

        return View('tanque.create')->withCombustiveis($combustiveis);
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
            'descricao_tanque' => 'required|min:3|unique:tanques',
            'combustivel_id' => 'required',
            'capacidade' => 'required|numeric'
        ]);
        try {
            $tanque = new Tanque($request->all());

            if ($tanque->save()) {
                Session::flash('success', 'Tanque '.$tanque->descricao_tanque.' cadastrado com sucesso.');
                return redirect()->action('TanqueController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('tanque.create')->withTanque(new Tanque($request->all()))->withCombustiveis(Combustivel::all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tanque  $tanque
     * @return \Illuminate\Http\Response
     */
    public function show(Tanque $tanque)
    {
        return View('tanque.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tanque  $tanque
     * @return \Illuminate\Http\Response
     */
    public function edit(Tanque $tanque)
    {
        $combustiveis = Combustivel::all();
        $tanque = Tanque::find($tanque->id);

        return View('tanque.edit')->withTanque($tanque)->withCombustiveis($combustiveis);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tanque  $tanque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tanque $tanque)
    {
        $this->validate($request, [
            'descricao_tanque' => 'string|required|min:3|unique:tanques,id,'.$tanque->id,
            'combustivel_id' => 'numeric|required',
            'capacidade' => 'numeric|required'
        ]);

        try {
            $tanque = Tanque::find($tanque->id);
            $tanque->descricao_tanque = $request->descricao_tanque;
            $tanque->combustivel_id = $request->combustivel_id;
            $tanque->capacidade = $request->capacidade;
            $tanque->posicao = $request->posicao;
            $tanque->ativo = $request->ativo;

            if ($tanque->save()) {
                Session::flash('success', 'Tanque '.$tanque->descricao_tanque.' alterado com sucesso.');
                return redirect()->action('TanqueController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao alterar o registro. '.$e->getMessage());
            return redirect()->back()->withTanque($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tanque  $tanque
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tanque $tanque)
    {
        try {
            $tanque = Tanque::find($tanque->id);
            if ($tanque->delete()) {
                Session::flash('success', 'Tanque '.$tanque->descricao_tanque.' removido com sucesso.');
                
                return redirect()->action('TanqueController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Registro não pode ser excluído. '.$e->getMessage());
            return redirect()->action('TanqueController@index');
        }
    }

    public function getTanquesJson(Request $request) {
        $tanques = Tanque::where('combustivel_id', $request->id)->get();

        return response()->json($tanques);
    }

    public function relPosicaoTanque() {
        $tanques = Tanque::select('tanques.*', 'combustiveis.descricao')
                        ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                        ->where('tanques.ativo', true)->get();
        
        $graficos = array();

        foreach ($tanques as $tanque) {
            $graficos[] = Charts::create('percentage', 'justgage')
                            ->title($tanque->descricao_tanque.' ('.$tanque->descricao.')')
                            ->elementLabel('Litros')
                            ->values([$this->getPosicaoEstoque($tanque), 0, $tanque->capacidade])
                            ->responsive(false)
                            ->height(250);
                            //->width(0);
        }

        return View('relatorios.tanques.posicao_tanques')->withTitulo('Posição de Estoque - Tanques')->withGraficos($graficos);
    }

    public function getPosicaoEstoque(Tanque $tanque) {
        $entradas = DB::table('tanque_movimentacoes')
                        ->where([
                            ['tanque_id', $tanque->id],
                            ['entrada_combustivel', true],
                            ['ativo', true]
                        ])
                        ->sum('quantidade_combustivel');

        $saidas = DB::table('tanque_movimentacoes')
                        ->where([
                            ['tanque_id', $tanque->id],
                            ['entrada_combustivel', false],
                            ['ativo', true]
                        ])
                        ->sum('quantidade_combustivel');

        return $entradas - $saidas;
    }

    public function listagemTanques() {
        $tanques = Tanque::all();

        return View('relatorios.tanques.listagem_tanques')->withTanques($tanques)->withTitulo('Listagem de Tanques')->withParametro(Parametro::first());
    }
}
