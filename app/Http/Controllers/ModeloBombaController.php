<?php

namespace App\Http\Controllers;

use App\ModeloBomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ModeloBombaController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'modelo_bomba' => 'Modelo de Bomba',
        'num_bicos' => 'Núm. Bicos',
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
            $modelo_bombas = ModeloBomba::where('modelo_bomba', 'like', '%'.$request->searchField.'%')->paginate();
        } else {
            $modelo_bombas = ModeloBomba::paginate();
        }
        return View('modelo_bomba.index', [
            'modelo_bombas' => $modelo_bombas,
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
        return View('modelo_bomba.create');
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
            'modelo_bomba' => 'required|string|unique:modelo_bombas',
            'num_bicos' => 'required|numeric'
        ]);

        try {
            $modelo_bomba = new ModeloBomba($request->all());
            if ($modelo_bomba->save()) {
                Session::flash('success', 'Modelo de Bomba '.$modelo_bomba->modelo_bomba.' cadastrado com sucesso.');

                return redirect()->action('ModeloBombaController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return redirect()->back()->withModelo_bomba($request->all());
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ModeloBomba  $modeloBomba
     * @return \Illuminate\Http\Response
     */
    public function show(ModeloBomba $modeloBomba)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ModeloBomba  $modeloBomba
     * @return \Illuminate\Http\Response
     */
    public function edit(ModeloBomba $modeloBomba)
    {
        $modelo_bomba = ModeloBomba::find($modeloBomba->id);
        return View('modelo_bomba.edit', [
            'modelo_bomba' => $modelo_bomba
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ModeloBomba  $modeloBomba
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModeloBomba $modeloBomba)
    {
        $this->validate($request, [
            'modelo_bomba' => 'required|string|unique:modelo_bombas,id,'.$modeloBomba->id,
            'num_bicos' => 'required|numeric'
        ]);

        try {
            $modelo_bomba = ModeloBomba::find($modeloBomba->id);
            $modelo_bomba->modelo_bomba = $request->modelo_bomba;
            $modelo_bomba->num_bicos = $request->num_bicos;
            $modelo_bomba->ativo = $request->ativo;

            if ($modelo_bomba->save()) {
                Session::flash('success', 'Modelo de Bomba '.$modelo_bomba->modelo_bomba.' alterado com sucesso.');

                return redirect()->action('ModeloBombaController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao alterar o registro. '.$e->getMessage());
            return redirect()->back()->withModelo_bomba($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ModeloBomba  $modeloBomba
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModeloBomba $modeloBomba)
    {
        try {
            $modelo_bomba = ModeloBomba::find($modeloBomba->id);
            if ($modelo_bomba->delete()) {
                Session::flash('success', 'Modelo de Bomba '.$modelo_bomba->modelo_bomba.' removido com sucesso.');
                
                return redirect()->action('ModeloBombaController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Registro não pode ser excluído. '.$e->getMessage());
            return redirect()->action('ModeloBombaController@index');
        }
    }
}
