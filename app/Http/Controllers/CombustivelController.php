<?php

namespace App\Http\Controllers;

use App\Combustivel;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Session;

class CombustivelController extends Controller
{

    public $fields = array(
        'id' => 'ID',
        'descricao' => 'Combustível',
        'valor' => 'Valor',
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

    public function teste(){
        return dd(get_class_vars(Combustivel::class)['fields']);
    }      

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->searchField)) {
            $combustiveis = Combustivel::where('descricao', 'like', '%'.$request->searchField.'%')->paginate();
        } else {
            $combustiveis = Combustivel::paginate();
        }

        return View('combustivel.index')->withCombustiveis($combustiveis)->withFields($this->fields);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('combustivel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $this->validar($request);
        try {
            $combustivel = new Combustivel($request->all());
            if ($combustivel->save()){
                Session::flash('success', 'Combustivel '.$combustivel->descricao.' cadastrado com sucesso.');
                
                return redirect()->action('CombustivelController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());

            return redirect()->back()->withCombustivel($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Combustivel  $combustivel
     * @return \Illuminate\Http\Response
     */
    public function show(Combustivel $combustivel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Combustivel  $combustivel
     * @return \Illuminate\Http\Response
     */
    public function edit(Combustivel $combustivel)
    {
        $combustivel = Combustivel::find($combustivel->id);

        return View('combustivel.edit')->withCombustivel($combustivel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Combustivel  $combustivel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Combustivel $combustivel)
    {
        $this->validate($request, [
            'descricao' => 'string|required|min:5|unique:combustiveis,id,'.$combustivel->id,
            'descricao_reduzida' => 'string|required|min:3|max:8|unique:combustiveis,id,'.$combustivel->id,
            'valor' => 'numeric|required'
        ]);

        try {           
            $combustivel = Combustivel::find($combustivel->id);
    
            $combustivel->descricao = $request->descricao;
            $combustivel->descricao_reduzida = $request->descricao_reduzida;
            $combustivel->valor = $request->valor;
            $combustivel->ativo = $request->ativo;            

            if ($combustivel->save()) {
                Session::flash('success', 'Combustivel '.$combustivel->descricao.' alterado com sucesso.');
                
                return redirect()->action('CombustivelController@index');
            }
            
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao alterar o registro. '.$e->getMessage());

            return redirect()->back()->withCombustivel($request->all());            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Combustivel  $combustivel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Combustivel $combustivel)
    {
        $combustivel = Combustivel::find($combustivel->id);
        
        try {
            $combustivel->delete();
        } catch (\Exception $e) {
            Session::flash('error', 'Registro não pode ser excluído. '.$e->getMessage());
        }

        Session::flash('success', 'Combustível '.$combustivel->descricao.' removido com sucesso.');

        return redirect()->action('CombustivelController@index');        
    }

    protected function validar(Request $request) {
        $this->validate($request, [
            'descricao' => 'string|required|min:5|unique:combustiveis',
            'descricao_reduzida' => 'string|required|min:3|max:8|unique:combustiveis',
            'valor' => 'numeric|required'
        ]);
    }
}
