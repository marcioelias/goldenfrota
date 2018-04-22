<?php

namespace App\Http\Controllers;

use App\GrupoProduto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GrupoProdutoController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'grupo_produto' => 'Grupo Produto',
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
            $grupoProdutos = GrupoProduto::where('grupo_produto', 'like', '%'.$request->searchField.'%')
                                            ->paginate();
        } else {
            $grupoProdutos = GrupoProduto::paginate();
        }

        return View('grupo_produto.index', [
            'grupoProdutos' => $grupoProdutos,
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
        return View('grupo_produto.create');
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
            'grupo_produto' => 'required|string|min:3|max:80|unique:grupo_produtos'
        ]);

        try {
            $grupoProduto = new GrupoProduto($request->all());

            if ($grupoProduto->save()) {
                Session::flash('success', 'Grupo de Produto '.$grupoProduto->grupo_produto.' cadastrado com sucesso.');
                return redirect()->action('GrupoProdutoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('grupo_produto.create', [
                'grupoProduto' => new GrupoProduto($request->all())
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GrupoProduto  $grupoProduto
     * @return \Illuminate\Http\Response
     */
    public function show(GrupoProduto $grupoProduto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GrupoProduto  $grupoProduto
     * @return \Illuminate\Http\Response
     */
    public function edit(GrupoProduto $grupoProduto)
    {
        $grupoProduto = GrupoProduto::find($grupoProduto->id);

        return View('grupo_produto.edit', [
            'grupoProduto' => $grupoProduto
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GrupoProduto  $grupoProduto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GrupoProduto $grupoProduto)
    {
        $this->validate($request, [
            'grupo_produto' => 'required|string|min:3|max:80|unique:grupo_produtos,id,'.$grupoProduto->id
        ]);

        try {
            $grupoProduto = GrupoProduto::find($grupoProduto->id);
            $grupoProduto->grupo_produto = $request->grupo_produto;
            $grupoProduto->ativo = $request->ativo;

            if ($grupoProduto->save()) {
                Session::flash('success', 'Grupo de Produto '.$grupoProduto->grupo_produto.' alterado com sucesso.');
                return redirect()->action('GrupoProdutoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('grupo_produto.edit', [
                'grupoProduto' => new GrupoProduto($request->all())
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GrupoProduto  $grupoProduto
     * @return \Illuminate\Http\Response
     */
    public function destroy(GrupoProduto $grupoProduto)
    {
        try {
            $grupoProduto = GrupoProduto::find($grupoProduto->id);
            if ($grupoProduto->delete()) {
                Session::flash('success', 'Grupo de Produto '.$grupoProduto->grupo_produto.' removido com sucesso.');
                
                return redirect()->action('GrupoProdutoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Registro não pode ser excluído. '.$e->getMessage());
            return redirect()->action('GrupoProdutoController@index');
        }
    }
}
