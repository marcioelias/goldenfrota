<?php

namespace App\Http\Controllers;

use App\MarcaVeiculo;
use App\ModeloVeiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ModeloVeiculoController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'marca_veiculo' => 'Marca',
        'modelo_veiculo' => 'Modelo',
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
        if ($request->searchField) {
            $modeloVeiculos = DB::table('modelo_veiculos')
                                ->select('modelo_veiculos.*', 'marca_veiculos.marca_veiculo')
                                ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
                                ->where('modelo_veiculo', 'like', '%'.$request->searchField.'%')
                                ->paginate();
        } else {
            $modeloVeiculos = DB::table('modelo_veiculos')
            ->select('modelo_veiculos.*', 'marca_veiculos.marca_veiculo')
            ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
            ->paginate();
        }

        return View('modelo_veiculo.index', [
            'modeloVeiculos' => $modeloVeiculos,
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
        $marcaVeiculos = MarcaVeiculo::all();

        return View('modelo_veiculo.create', [
            'marcaVeiculos' => $marcaVeiculos
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
            'modelo_veiculo' => 'required|string|min:3|max:30|unique:modelo_veiculos',
            'marca_veiculo_id' => 'required|integer|exists:marca_veiculos,id',
            'capacidade_tanque' => 'required|integer|min:0'
        ]);

        try {
            $modeloVeiculo = new ModeloVeiculo($request->all());

            if ($modeloVeiculo->save()) {
                Session::flash('success', 'Modelo de Veículo '.$modeloVeiculo->modelo_veiculo.' cadastrado com sucesso.');
                return redirect()->action('ModeloVeiculoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('modelo_veiculo.create', [
                'modeloVeiculo' => new ModeloVeiculo($request->all()),
                'marcaVeiculos' => MarcaVeiculo::all()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ModeloVeiculo  $modeloVeiculo
     * @return \Illuminate\Http\Response
     */
    public function show(ModeloVeiculo $modeloVeiculo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ModeloVeiculo  $modeloVeiculo
     * @return \Illuminate\Http\Response
     */
    public function edit(ModeloVeiculo $modeloVeiculo)
    {
        $marcaVeiculos = MarcaVeiculo::all();
        $modeloVeiculo = ModeloVeiculo::find($modeloVeiculo->id);

        return View('modelo_veiculo.edit', [
            'marcaVeiculos' => $marcaVeiculos,
            'modeloVeiculo' => $modeloVeiculo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ModeloVeiculo  $modeloVeiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModeloVeiculo $modeloVeiculo)
    {
        $this->validate($request, [
            'modelo_veiculo' => 'required|string|min:3|max:30|unique:modelo_veiculos,id,'.$modeloVeiculo->id,
            'marca_veiculo_id' => 'required|integer|exists:marca_veiculos,id',
            'capacidade_tanque' => 'required|integer|min:0'
        ]);

        try {
            $modeloVeiculo = ModeloVeiculo::find($modeloVeiculo->id);
            $modeloVeiculo->modelo_veiculo = $request->modelo_veiculo;
            $modeloVeiculo->marca_veiculo_id = $request->marca_veiculo_id;
            $modeloVeiculo->capacidade_tanque = $request->capacidade_tanque;
            $modeloVeiculo->ativo = $request->ativo;

            if ($modeloVeiculo->save()) {
                Session::flash('success', 'Modelo de Veículo '.$modeloVeiculo->modelo_veiculo.' alterado com sucesso.');
                return redirect()->action('ModeloVeiculoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('modelo_veiculo.edit', [
                'modeloVeiculo' => new ModeloVeiculo($request->all()),
                'marcaVeiculos' => MarcaVeiculo::all()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ModeloVeiculo  $modeloVeiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModeloVeiculo $modeloVeiculo)
    {
        try {
            $modeloVeiculo = ModeloVeiculo::find($modeloVeiculo->id);
            if ($modeloVeiculo->delete()) {
                Session::flash('success', 'Modelo de Veículo '.$modeloVeiculo->modelo_veiculo.' removido com sucesso.');
                
                return redirect()->action('ModeloVeiculoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Registro não pode ser excluído. '.$e->getMessage());
            return redirect()->action('ModeloVeiculoController@index');
        }
    }

    public function getModelosJson(Request $request) {
        $modeloVeiculos = ModeloVeiculo::where('marca_veiculo_id', $request->id)->get();

        return response()->json($modeloVeiculos);
    }
}
