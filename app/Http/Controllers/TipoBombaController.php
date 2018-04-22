<?php

namespace App\Http\Controllers;

use App\TipoBomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TipoBombaController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'tipo_bomba' => 'Tipo Bomba',
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
            $tipo_bombas = TipoBomba::where('tipo_bomba', 'like', '%'.$request->searchField.'%')->paginate();
        } else {
            $tipo_bombas = TipoBomba::paginate();
        }
        return View('tipo_bomba.index', [
            'tipo_bombas' => $tipo_bombas,
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
        return View('tipo_bomba.create');
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
            'tipo_bomba' => 'required|string|unique:tipo_bombas'
        ]);

        try {
            $tipo_bomba = new TipoBomba($request->all());
            if ($tipo_bomba->save()) {
                Session::flash('success', 'Tipo de Bomba '.$tipo_bomba->tipo_bomba.' cadastrado com sucesso.');

                return redirect()->action('TipoBombaController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return redirect()->back()->withTipo_bomba($request->all());
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TipoBomba  $tipoBomba
     * @return \Illuminate\Http\Response
     */
    public function show(TipoBomba $tipoBomba)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TipoBomba  $tipoBomba
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoBomba $tipoBomba)
    {
        $tipo_bomba = TipoBomba::find($tipoBomba->id);
        return View('tipo_bomba.edit', [
            'tipo_bomba' => $tipo_bomba
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoBomba  $tipoBomba
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoBomba $tipoBomba)
    {
        $this->validate($request, [
            'tipo_bomba' => 'required|string|unique:tipo_bombas,id,'.$tipoBomba->id
        ]);
        
        try {
            $tipo_bomba = TipoBomba::find($tipoBomba->id);
            $tipo_bomba->tipo_bomba = $request->tipo_bomba;
            $tipo_bomba->ativo = $request->ativo;

            if ($tipo_bomba->save()) {
                Session::flash('success', 'Tipo de Bomba '.$tipo_bomba->tipo_bomba.' alterado com sucesso.');

                return redirect()->action('TipoBombaController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao alterar o registro. '.$e->getMessage());
            return redirect()->back()->withTipo_bomba($request->all());
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoBomba  $tipoBomba
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoBomba $tipoBomba)
    {
        try {
            $tipo_bomba = TipoBomba::find($tipoBomba->id);
            if ($tipo_bomba->delete()) {
                Session::flash('success', 'Tipo de Bomba '.$tipo_bomba->tipo_bomba.' removido com sucesso.');
                
                return redirect()->action('TipoBombaController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Registro não pode ser excluído. '.$e->getMessage());
            return redirect()->action('TipoBombaController@index');
        }
    }
}
