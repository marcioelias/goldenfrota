<?php

namespace App\Http\Controllers;

use App\Bico;
use App\Bomba;
use App\Tanque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BicoController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'num_bico' => 'N. Bico',
        'descricao_bomba' => 'Bomba',
        'descricao' => 'Combustível',
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
            $bicos = DB::table('bicos')
                        ->select('bicos.*', 'bombas.descricao_bomba', 'combustiveis.descricao')
                        ->join('tanques', 'tanques.id', 'bicos.tanque_id')
                        ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                        ->join('bombas', 'bombas.id', 'bicos.bomba_id')
                        ->where('num_bico', $request->searchField)
                        ->orWhere('combustiveis.descricao', 'like', '%'.$request->searchField.'%')
                        ->paginate();
        } else {
            $bicos = DB::table('bicos')
                        ->select('bicos.*', 'bombas.descricao_bomba', 'combustiveis.descricao')
                        ->join('tanques', 'tanques.id', 'bicos.tanque_id')
                        ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                        ->join('bombas', 'bombas.id', 'bicos.bomba_id')
                        ->paginate();
        }

        return View('bico.index')->withBicos($bicos)->withFields($this->fields);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tanques = Tanque::all();
        $bombas = Bomba::all();

        return View('bico.create')->withTanques($tanques)->withBombas($bombas);
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
            'num_bico' => 'required|integer|unique:bicos',
            'tanque_id' => 'required|integer|exists:tanques,id',
            'bomba_id' => 'required|integer|exists:bombas,id',
            'encerrante' => 'required|numeric|min:0'
        ]);

        try {
            $bico = new Bico($request->all());

            if ($bico->save()) {
                Session::flash('success', 'Bico '.$bico->num_bico.' cadastrado com sucesso.');
                return redirect()->action('BicoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('bico.create', [
                'bico' => new Bico($request->all()),
                'tanques' => Tanque::all(),
                'bombas' => Bomba::all()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bico  $bico
     * @return \Illuminate\Http\Response
     */
    public function show(Bico $bico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bico  $bico
     * @return \Illuminate\Http\Response
     */
    public function edit(Bico $bico)
    {
        $tanques = Tanque::all();
        $bombas = Bomba::all();
        $bico = Bico::find($bico->id);

        return View('bico.edit')->withBico($bico)->withTanques($tanques)->withBombas($bombas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bico  $bico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bico $bico)
    {
        $this->validate($request, [
            'num_bico' => 'required|integer|unique:bicos,id,'.$bico->id,
            'tanque_id' => 'required|integer|exists:tanques,id',
            'bomba_id' => 'required|integer|exists:bombas,id',
            'encerrante' => 'required|numeric|min:0'
        ]);

        try {
            $bico = Bico::find($bico->id);

            $bico->num_bico = $request->num_bico;
            $bico->tanque_id = $request->tanque_id;
            $bico->bomba_id = $request->bomba_id;
            $bico->encerrante = $request->encerrante;
            $bico->ativo = $request->ativo;

            if ($bico->save()) {
                Session::flash('success', 'Bico '.$bico->num_bico.' alterado com sucesso.');
                return redirect()->action('BicoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('bico.edit', [
                'bico' => new Bico($request->all()),
                'tanques' => Tanque::all(),
                'bombas' => Bomba::all()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bico  $bico
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bico $bico)
    {
        try {
            $bico = Bico::find($bico->id);
            if ($bico->delete()) {
                Session::flash('success', 'Bico '.$bico->num_bico.' removido com sucesso.');
                
                return redirect()->action('BicoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Registro não pode ser excluído. '.$e->getMessage());
            return redirect()->action('BicoController@index');
        }
    }
}
