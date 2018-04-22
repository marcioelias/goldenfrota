<?php

namespace App\Http\Controllers;

use App\Bomba;
use App\TipoBomba;
use App\ModeloBomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class BombaController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'descricao_bomba' => 'Bomba',
        'tipo_bomba' => 'Tipo de Bomba',
        'modelo_bomba' => 'Modelo de Bomba',
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
            $bombas = DB::table('bombas')
                            ->select('bombas.*', 'tipo_bombas.tipo_bomba', 'modelo_bombas.modelo_bomba')
                            ->join('tipo_bombas', 'tipo_bombas.id', 'bombas.tipo_bomba_id')
                            ->join('modelo_bombas', 'modelo_bombas.id', 'bombas.modelo_bomba_id')
                            ->where('descricao_bomba', 'like', '%'.$request->searchField.'%')
                            ->paginate();
        } else {
            $bombas = DB::table('bombas')
                            ->select('bombas.*', 'tipo_bombas.tipo_bomba', 'modelo_bombas.modelo_bomba')
                            ->join('tipo_bombas', 'tipo_bombas.id', 'bombas.tipo_bomba_id')
                            ->join('modelo_bombas', 'modelo_bombas.id', 'bombas.modelo_bomba_id')
                            ->paginate();
        }

        return View('bomba.index')->withBombas($bombas)->withFields($this->fields);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipoBombas = TipoBomba::all();
        $modeloBombas = ModeloBomba::all();

        return View('bomba.create', [
            'tipoBombas' => $tipoBombas,
            'modeloBombas' => $modeloBombas
        ]);
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
            'descricao_bomba' => 'string|required|min:3|unique:bombas',
            'tipo_bomba_id' => 'numeric|required',
            'modelo_bomba_id' => 'numeric|required'            
        ]);

        try {
            $bomba = new Bomba($request->all());

            if ($bomba->save()) {
                Session::flash('success', 'Bomba '.$bomba->descricao_bomba.' cadastrada com sucesso.');
                return redirect()->action('BombaController@index');
            } 
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('bomba.create', [
                'bomba' => new Bomba($request->all()),
                'tipoBombas' => TipoBomba::all(),
                'modeloBombas' => ModeloBomba::all()
            ]);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bomba  $bomba
     * @return \Illuminate\Http\Response
     */
    public function show(Bomba $bomba)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bomba  $bomba
     * @return \Illuminate\Http\Response
     */
    public function edit(Bomba $bomba)
    {
        $tipoBombas = TipoBomba::all();
        $modeloBombas = ModeloBomba::all();
        $bomba = Bomba::find($bomba->id);

        return View('bomba.edit', [
            'bomba' => $bomba,
            'tipoBombas' => $tipoBombas,
            'modeloBombas' => $modeloBombas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bomba  $bomba
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bomba $bomba)
    {
        $this->validate($request, [
            'descricao_bomba' => 'string|required|min:3|unique:bombas,id,'.$bomba->id,
            'tipo_bomba_id' => 'numeric|required',
            'modelo_bomba_id' => 'numeric|required'            
        ]);

        try {
            $aux = Bomba::find($bomba->id);

            $aux->descricao_bomba = $request->descricao_bomba;
            $aux->modelo_bomba_id = $request->modelo_bomba_id;
            $aux->tipo_bomba_id = $request->tipo_bomba_id;
            $aux->ativo = $request->ativo;

            if ($aux->save()) {
                Session::flash('success', 'Bomba '.$bomba->descricao_bomba.' alterada com sucesso.');
                return redirect()->action('BombaController@index');
            } 
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('bomba.create', [
                'bomba' => Bomba::find($bomba->id),
                'tipoBombas' => TipoBomba::all(),
                'modeloBombas' => ModeloBomba::all()
            ]);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bomba  $bomba
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bomba $bomba)
    {
        try {
            $bomba = Bomba::find($bomba->id);
            if ($bomba->delete()) {
                Session::flash('success', 'Bomba '.$bomba->descricao_bomba.' removida com sucesso.');
                
                return redirect()->action('BombaController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Registro não pode ser excluído. '.$e->getMessage());
            return redirect()->action('BombaController@index');
        }
    }
}
