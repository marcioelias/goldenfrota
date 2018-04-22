<?php

namespace App\Http\Controllers;

use App\Produto;
use App\Unidade;
use App\GrupoProduto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProdutoController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'produto_descricao' => 'Descrição',
        'produto_desc_red' => 'Descrição Reduzida',
        'unidade' => 'Unidade',
        'grupo_produto' => 'Grupo',
        'valor_unitario' => 'Valor',
        'qtd_estoque' => 'Qtd. Estoque',
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
            $produtos = DB::table('produtos')
                            ->select('produtos.*', 'unidades.unidade', 'grupo_produtos.grupo_produto')
                            ->join('unidades', 'unidades.id', 'produtos.unidade_id')
                            ->join('grupo_produtos', 'grupo_produtos.id', 'produtos.grupo_produto_id')
                            ->where('produto_descricao', 'like', '%'.$request->searchField.'%')
                            ->orWhere('produto_desc_red', 'like', '%'.$request->searchField.'%')
                            ->paginate();
        } else {
            $produtos = DB::table('produtos')
                            ->select('produtos.*', 'unidades.unidade', 'grupo_produtos.grupo_produto')
                            ->join('unidades', 'unidades.id', 'produtos.unidade_id')
                            ->join('grupo_produtos', 'grupo_produtos.id', 'produtos.grupo_produto_id')
                            ->paginate();
        }

        return View('produto.index')->withProdutos($produtos)->withFields($this->fields);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unidades = Unidade::all();
        $grupoProdutos = GrupoProduto::all();

        return View('produto.create', [
            'unidades' => $unidades,
            'grupoProdutos' => $grupoProdutos
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
            'produto_descricao' => 'required|string|min:3|max:60|unique:produtos',
            'produto_desc_red' => 'nullable|string|min:3|max:10',
            'unidade_id' => 'required',
            'valor_unitario' => 'required|numeric',
            'grupo_produto_id' => 'required',
            'qtd_estoque' => 'required|numeric'
        ]);

        try {
            $produto = new Produto($request->all());

            if ($produto->save()) {
                Session::flash('success', 'Produto '.$produto->produto_descricao.' cadastrado com sucesso.');
                return redirect()->action('ProdutoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('produto.create', [
                'produto' => new Produto($request->all()),
                'unidades' => Unidade::all(),
                'grupoProdutos' => GrupoProduto::all()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show(Produto $produto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit(Produto $produto)
    {
        $unidades = Unidade::all();
        $grupoProdutos = GrupoProduto::all();
        $produto = Produto::find($produto->id);

        return View('produto.edit', [
            'produto' => $produto,
            'unidades' => $unidades,
            'grupoProdutos' => $grupoProdutos
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produto $produto)
    {
        /* $request->valor_unitario = substr(',', '.', $request->valor_unitario); */   
        $this->validate($request, [
            'produto_descricao' => 'required|string|min:3|max:60|unique:produtos,id,'.$produto->id,
            'produto_desc_red' => 'nullable|string|min:3|max:10',
            'unidade_id' => 'required',
            'valor_unitario' => 'required|numeric',
            'grupo_produto_id' => 'required',
            'qtd_estoque' => 'required|numeric'
        ]);

        try {
            $produto = Produto::find($produto->id);
            $produto->produto_descricao = $request->produto_descricao;
            $produto->produto_desc_red = $request->produto_desc_red;
            $produto->unidade_id = $request->unidade_id;
            $produto->valor_unitario = $request->valor_unitario;
            $produto->grupo_produto_id = $request->grupo_produto_id;
            $produto->qtd_estoque = $request->qtd_estoque;
            $produto->ativo = $request->ativo;

            if ($produto->save()) {
                Session::flash('success', 'Produto '.$produto->produto_descricao.' alterado com sucesso.');
                return redirect()->action('ProdutoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return View('produto.edit', [
                'produto' => new Produto($request->all()),
                'unidades' => Unidade::all(),
                'grupoProdutos' => GrupoProduto::all()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produto $produto)
    {
        try {
            $produto = Produto::find($produto->id);
            if ($produto->delete()) {
                Session::flash('success', 'Produto '.$produto->produto_descricao.' removido com sucesso.');
                
                return redirect()->action('ProdutoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Registro não pode ser excluído. '.$e->getMessage());
            return redirect()->action('ProdutoController@index');
        }
    }
}
