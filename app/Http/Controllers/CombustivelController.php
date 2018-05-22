<?php

namespace App\Http\Controllers;

use App\Combustivel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarCombustiveis()) {
            if (isset($request->searchField)) {
                $combustiveis = Combustivel::where('descricao', 'like', '%'.$request->searchField.'%')->paginate();
            } else {
                $combustiveis = Combustivel::paginate();
            }

            return View('combustivel.index')->withCombustiveis($combustiveis)->withFields($this->fields);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->canCadastrarCombustiveis()) {
            return View('combustivel.create');
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        if (Auth::user()->canCadastrarCombustiveis()) {
            $this->validate($request, [
                'descricao' => 'string|required|min:5|unique:combustiveis',
                'descricao_reduzida' => 'string|required|min:3|max:8|unique:combustiveis',
                'valor' => 'numeric|required'
            ]);

            try {
                $combustivel = new Combustivel($request->all());
                if ($combustivel->save()){
                    Session::flash('success', __('messages.create_success', [
                        'model' => __('combustivel'),
                        'name' => $combustivel->descricao
                    ]));
                    
                    return redirect()->action('CombustivelController@index');
                }
            } catch (\Exception $e) {
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return redirect()->back()->withInput();
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Combustivel  $combustivel
     * @return \Illuminate\Http\Response
     */
    public function edit(Combustivel $combustivel)
    {
        if (Auth::user()->canAlterarCombustiveis()) {
            return View('combustivel.edit')->withCombustivel($combustivel);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
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
        if (Auth::user()->canAlterarCombustiveis()) {
            $this->validate($request, [
                'descricao' => 'string|required|min:5|unique:combustiveis,id,'.$combustivel->id,
                'descricao_reduzida' => 'string|required|min:3|max:8|unique:combustiveis,id,'.$combustivel->id,
                'valor' => 'numeric|required'
            ]);

            try {                 
                $combustivel->descricao = $request->descricao;
                $combustivel->descricao_reduzida = $request->descricao_reduzida;
                $combustivel->valor = $request->valor;
                $combustivel->ativo = $request->ativo;            

                if ($combustivel->save()) {
                    Session::flash('success', __('messages.update_success', [
                        'model' => 'combustivel',
                        'name' => $combustivel->descricao
                    ]));
                    return redirect()->action('CombustivelController@index');
                }
            } catch (\Exception $e) {
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return redirect()->back()->withInput();            
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
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
        if (Auth::user()->canExcluirCombustiveis()) {   
            try {
                if ($combustivel->delete()) {
                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('combustivel'),
                        'name' => $combustivel->descricao
                    ]));
                    return redirect()->action('ClienteController@index');
                }
            } catch (\Exception $e) {
                switch ($e->getCode()) {
                    case 23000:
                        Session::flash('error', __('messages.fk_exception'));
                        break;
                    default:
                        Session::flash('error', __('messages.exception', [
                            'exception' => $e->getMessage()
                        ]));
                        break;
                }
                return redirect()->action('CombustivelController@index');        
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }
}
