<?php

namespace App\Http\Controllers;

use App\MarcaVeiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class MarcaVeiculoController extends Controller
{

    protected $fields = array(
        'id' => 'ID',
        'marca_veiculo' => 'Marca',
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
            $marcaVeiculos = MarcaVeiculo::where('marca_veiculo', 'like', '%'.$request->searchField.'%')
                                        ->paginate();
        } else {
            $marcaVeiculos = MarcaVeiculo::paginate();
        }

        return View('marca_veiculo.index', [
            'marcaVeiculos' => $marcaVeiculos,
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
        return View('marca_veiculo.create');
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
            'marca_veiculo' => 'required|string|min:3|max:30|unique:marca_veiculos'
        ]);

        try {
            $marcaVeiculo = new MarcaVeiculo($request->all());

            if ($marcaVeiculo->save()) {
                Session::flash('success', 'Marca de Veículo '.$marcaVeiculo->marca_veiculo.' cadastrada com sucesso.');
                return redirect()->action('MarcaVeiculoController@index');
            } 
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('marca_veiculo.create', [
                'marcaVeiculo' => new MarcaVeiculo($request->all())
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MarcaVeiculo  $marcaVeiculo
     * @return \Illuminate\Http\Response
     */
    public function show(MarcaVeiculo $marcaVeiculo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MarcaVeiculo  $marcaVeiculo
     * @return \Illuminate\Http\Response
     */
    public function edit(MarcaVeiculo $marcaVeiculo)
    {
        $marcaVeiculo = MarcaVeiculo::find($marcaVeiculo->id);

        return View('marca_veiculo.edit', [
            'marcaVeiculo' => $marcaVeiculo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MarcaVeiculo  $marcaVeiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MarcaVeiculo $marcaVeiculo)
    {
        $this->validate($request, [
            'marca_veiculo' => 'required|string|min:3|max:30|unique:marca_veiculos,id,'.$marcaVeiculo->id
        ]);

        try {
            $marcaVeiculo = MarcaVeiculo::find($marcaVeiculo->id);

            $marcaVeiculo->marca_veiculo = $request->marca_veiculo;
            $marcaVeiculo->ativo = $request->ativo;

            if ($marcaVeiculo->save()) {
                Session::flash('success', 'Marca de Veículo '.$marcaVeiculo->marca_veiculo.' alterada com sucesso.');
                return redirect()->action('MarcaVeiculoController@index');
            } 
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('marca_veiculo.edit', [
                'marcaVeiculo' => new MarcaVeiculo($request->all())
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MarcaVeiculo  $marcaVeiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy(MarcaVeiculo $marcaVeiculo)
    {
        try {
            $marcaVeiculo = MarcaVeiculo::find($marcaVeiculo->id);

            if ($marcaVeiculo->delete()) {
                Session::flash('success', 'Marca de Veículo '.$marcaVeiculo->marca_veiculo.' removida com sucesso.');
                
                return redirect()->action('MarcaVeiculoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Registro não pode ser excluído. '.$e->getMessage());
            return redirect()->action('MarcaVeiculoController@index');
        }
    }
}
