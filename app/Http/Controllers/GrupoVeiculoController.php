<?php

namespace App\Http\Controllers;

use App\GrupoVeiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GrupoVeiculoController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'grupo_veiculo' => 'Grupo Veículo',
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
        if (isset($requet->searchField)) {
            $grupoVeiculos = GrupoVeiculo::where('grupo_veiculo', 'like', '%'.$request->searchField.'%')->paginate();
        } else {
            $grupoVeiculos = GrupoVeiculo::paginate();
        }

        return View('grupo_veiculo.index', [
            'grupoVeiculos' => $grupoVeiculos,
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
        return View('grupo_veiculo.create');
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
            'grupo_veiculo' => 'required|unique:grupo_veiculos'
        ]);

        try {
            $grupoVeiculo = new GrupoVeiculo($request->all());

            if ($grupoVeiculo->save()) {
                Session::flash('success', 'Grupo de Veículo '.$grupoVeiculo->grupo_veiculo.' cadastrado com sucesso.');
                return redirect()->action('GrupoVeiculoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('grupo_veiculo.create', [
                'grupoVeiculo' => new GrupoVeiculo($request->all())
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GrupoVeiculo  $grupoVeiculo
     * @return \Illuminate\Http\Response
     */
    public function show(GrupoVeiculo $grupoVeiculo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GrupoVeiculo  $grupoVeiculo
     * @return \Illuminate\Http\Response
     */
    public function edit(GrupoVeiculo $grupoVeiculo)
    {
        $grupoVeiculo = GrupoVeiculo::find($grupoVeiculo->id);

        return View('grupo_veiculo.edit', [
            'grupoVeiculo' => $grupoVeiculo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GrupoVeiculo  $grupoVeiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GrupoVeiculo $grupoVeiculo)
    {
        $this->validate($request, [
            'grupo_veiculo' => 'required|unique:grupo_veiculos,id,'.$grupoVeiculo->id
        ]);

        try {
            $grupoVeiculo = GrupoVeiculo::find($grupoVeiculo->id);
            $grupoVeiculo->grupo_veiculo = $request->grupo_veiculo;
            $grupoVeiculo->ativo = $request->ativo;

            if ($grupoVeiculo->save()) {
                Session::flash('success', 'Grupo de Veículo '.$grupoVeiculo->grupo_veiculo.' alterado com sucesso.');
                return redirect()->action('GrupoVeiculoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('grupo_veiculo.update', [
                'grupoVeiculo' => new GrupoVeiculo($request->all())
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GrupoVeiculo  $grupoVeiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy(GrupoVeiculo $grupoVeiculo)
    {
        try {
            $grupoVeiculo = GrupoVeiculo::find($grupoVeiculo->id);
            if ($grupoVeiculo->delete()) {
                Session::flash('success', 'Grupo de Veículo '.$grupoVeiculo->grupo_veiculo.' removido com sucesso.');
                
                return redirect()->action('GrupoVeiculoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Registro não pode ser excluído. '.$e->getMessage());
            return redirect()->action('GrupoVeiculoController@index');
        }
    }
}
