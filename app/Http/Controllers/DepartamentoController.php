<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DepartamentoController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'departamento' => 'Departamento',
        'nome_razao' => 'Cliente',
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
            $departamentos = DB::table('departamentos')
                            ->select('departamentos.*', 'clientes.nome_razao')
                            ->join('clientes', 'clientes.id', 'departamentos.cliente_id')
                            ->where('departamentos.departamento', 'like', '%'.$request->searchField.'%')
                            ->orWhere('clientes.nome_razao', 'like', '%'.$request->searchField.'%')
                            ->paginate();
        } else {
            $departamentos = DB::table('departamentos')
                            ->select('departamentos.*', 'clientes.nome_razao')
                            ->join('clientes', 'clientes.id', 'departamentos.cliente_id')
                            ->paginate();
        }

        return View('departamento.index')->withDepartamentos($departamentos)->withFields($this->fields);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = Cliente::where('ativo', true)->get();

        return View('departamento.create')->withClientes($clientes);
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
            'departamento' => 'required|string|unique:departamentos,departamento,NULL,id,cliente_id,'.$request->cliente_id,
            'cliente_id' => 'required'
        ]);

        try {
            $departamento = new Departamento($request->all());

            if ($departamento->save()) {
                Session::flash('success', 'Departamento '.$departamento->departamento.' cadastrado com sucesso.');
                return redirect()->action('DepartamentoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('departamento.create', [
                'departamento' => new Departamento($request->all()),
                'clientes' => Cliente::where('ativo', true)->get()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function show(Departamento $departamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Departamento $departamento)
    {
        $departamento = Departamento::find($departamento->id);
        $clientes = Cliente::where('ativo', true)->orWhere('clientes.id', $departamento->cliente_id)->get();

        return View('departamento.edit')->withDepartamento($departamento)->withClientes($clientes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Departamento $departamento)
    {
        $this->validate($request, [
            'departamento' => 'required|string|unique:departamentos,cliente_id,'.$request->cliente_id,
            'cliente_id' => 'required'
        ]);

        try {
            $departamento = Departamento::find($departamento->id);

            $departamento->departamento = $request->departamento;
            $departamento->cliente_id = $request->cliente_id;
            $departamento->ativo = $request->ativo;

            if ($departamento->save()) {
                Session::flash('success', 'Departamento '.$departamento->departamento.' alterado com sucesso.');
                return redirect()->action('DepartamentoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao alterar os dados. '.$e->getMessage());
            return View('departamento.edit', [
                'departamento' => $departamento,
                'clientes' => Cliente::where('ativo', true)->orWhere('clientes.id', $departamento->cliente_id)->get()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departamento $departamento)
    {
        try {
            $departamento = Departamento::find($departamento->id);
            if ($departamento->delete()) {
                Session::flash('success', 'Departamento '.$departamento->departamento.' removido com departamentoucesso.');
                
                return redirect()->action('DepartamentoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Registro não pode ser excluído. '.$e->getMessage());
            return redirect()->action('DepartamentoController@index');
        }
    }

    public function getDepartamentosJson(Request $request) {
        $departamentos = Departamento::where([
                        ['cliente_id', '=', $request->id],
                        ['ativo', '=', 1]
                    ])->get();

        return response()->json($departamentos);
    }
}
