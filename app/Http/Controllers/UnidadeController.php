<?php

namespace App\Http\Controllers;

use App\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UnidadeController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'unidade' => 'Unidade',
        'permite_fracionamento' => ['label' => 'Permite Fracionamento', 'type' => 'bool'],
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
            $unidades = Unidade::where('unidade', 'like', '%'.$request->searchField.'%')
                                ->paginate();
        } else {
            $unidades = Unidade::paginate();
        }

        return View('unidade.index')->withUnidades($unidades)->withFields($this->fields);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('unidade.create');
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
            'unidade' => 'required|string|min:2|max:20|unique:unidades'
        ]);

        try {
            $unidade = new Unidade($request->all());

            if ($unidade->save()) {
                Session::flash('success', 'Unidade '.$request->unidade.' criada com sucesso.');

                return redirect()->action('UnidadeController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Erro ao criar a Unidade. '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function show(Unidade $unidade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function edit(Unidade $unidade)
    {
        $unidade = Unidade::find($unidade->id);

        return View('unidade.edit')->withUnidade($unidade);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unidade $unidade)
    {
        $this->validate($request, [
            'unidade' => 'required|string|min:2|max:20|unique:unidades,id,'.$unidade->id
        ]);

        try {
            $unidade = Unidade::find($unidade->id);
            $unidade->unidade = $request->unidade;
            $unidade->permite_fracionamento = $request->permite_fracionamento;
            $unidade->ativo = $request->ativo;

            if ($unidade->save()) {
                Session::flash('success', 'Unidade '.$request->unidade.' alterada com sucesso.');

                return redirect()->action('UnidadeController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Não foi possível alterar a unidade. '.$e->getMessage());
            return redirect()->back()->withUnidade($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unidade $unidade)
    {
        try {
            $unidade = Unidade::find($unidade->id);
            if ($unidade->delete()) {
                Session::flash('success', 'Unidade '.$unidade->unidade.' removida com sucesso.');
                
                return redirect()->action('UnidadeController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Não foi possível remover a unidade. '.$e->getMessage());
            return redirect()->action('UnidadeController@index');
        }
    }
}
