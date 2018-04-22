<?php

namespace App\Http\Controllers;

use App\Atendente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AtendenteController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'nome_atendente' => 'Atendente',
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
            $atendentes = Atendente::where('nome_atendente', 'like', '%'.$request->searchField.'%')
                            ->paginate();
        } else {
            $atendentes = Atendente::paginate();
        }

        return View('atendente.index')->withAtendentes($atendentes)->withFields($this->fields);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('atendente.create');
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
            'nome_atendente' => 'required|string',
            'usuario_atendente' => 'required|string|max:10|unique:atendentes',
            'senha_atendente' => 'required|string|max:16'
        ]);

        try {
            $atendente = new Atendente($request->all());

            if ($atendente->save()) {
                Session::flash('success', 'Atendente '.$atendente->nome_atendente.' cadastrado com sucesso.');
                return redirect()->action('AtendenteController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('atendente.create', [
                'atendente' => new Atendente($request->all())
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Atendente  $atendente
     * @return \Illuminate\Http\Response
     */
    public function show(Atendente $atendente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Atendente  $atendente
     * @return \Illuminate\Http\Response
     */
    public function edit(Atendente $atendente)
    {
        $atendente = Atendente::find($atendente->id);

        return View('atendente.edit')->withAtendente($atendente);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Atendente  $atendente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Atendente $atendente)
    {
        $this->validate($request, [
            'nome_atendente' => 'required|string',
            'usuario_atendente' => 'required|string|max:10|unique:atendentes,id,'.$atendente->id,
            'senha_atendente' => 'required|string|max:16'
        ]);

        try {
            $atendente = Atendente::find($atendente->id);

            $atendente->nome_atendente = $request->nome_atendente;
            $atendente->usuario_atendente = $request->usuario_atendente;
            $atendente->senha_atendente = $request->senha_atendente;
            $atendente->ativo = $request->ativo;

            if ($atendente->save()) {
                Session::flash('success', 'Atendente '.$atendente->nome_atendente.' alterado com sucesso.');
                return redirect()->action('AtendenteController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('atendente.edit', [
                'atendente' => new Atendente($request->all())
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Atendente  $atendente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Atendente $atendente)
    {
        try {
            $atendente = Atendente::find($Atendente->id);
            if ($atendente->delete()) {
                Session::flash('success', 'Atendente '.$atendente->nome_atendnete.' removido com sucesso.');
                
                return redirect()->action('AtendenteController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Registro não pode ser excluído. '.$e->getMessage());
            return redirect()->action('AtendenteController@index');
        }
    }
}
