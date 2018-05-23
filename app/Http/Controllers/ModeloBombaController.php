<?php

namespace App\Http\Controllers;

use App\ModeloBomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ModeloBombaController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'modelo_bomba' => 'Modelo de Bomba',
        'num_bicos' => 'Núm. Bicos',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarModeloBomba()) {
            if (isset($request->searchField)) {
                $modelo_bombas = ModeloBomba::where('modelo_bomba', 'like', '%'.$request->searchField.'%')->paginate();
            } else {
                $modelo_bombas = ModeloBomba::paginate();
            }
            return View('modelo_bomba.index', [
                'modelo_bombas' => $modelo_bombas,
                'fields' => $this->fields
            ]);
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
        if (Auth::user()->canCadastrarModeloBomba()) {
            return View('modelo_bomba.create');
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
        if (Auth::user()->canCadastrarModeloBomba()) {
            $this->validate($request, [
                'modelo_bomba' => 'required|string|unique:modelo_bombas',
                'num_bicos' => 'required|numeric'
            ]);

            try {
                $modelo_bomba = new ModeloBomba($request->all());
                if ($modelo_bomba->save()) {
                    Session::flash('success', __('messages.create_success', [
                        'model' => __('modelo_bomba'),
                        'name' => $modelo_bomba->modelo_bomba
                    ]));
                    return redirect()->action('ModeloBombaController@index');
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
     * @param  \App\ModeloBomba  $modeloBomba
     * @return \Illuminate\Http\Response
     */
    public function edit(ModeloBomba $modeloBomba)
    {
        if (Auth::user()->canAlterarModeloBomba()) {
            return View('modelo_bomba.edit', [
                'modelo_bomba' => $modelo_bomba
            ]);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ModeloBomba  $modeloBomba
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModeloBomba $modeloBomba)
    {
        if (Auth::user()->canAlterarModeloBomba()) {
            $this->validate($request, [
                'modelo_bomba' => 'required|string|unique:modelo_bombas,id,'.$modeloBomba->id,
                'num_bicos' => 'required|numeric'
            ]);

            try {
                $modelo_bomba->modelo_bomba = $request->modelo_bomba;
                $modelo_bomba->num_bicos = $request->num_bicos;
                $modelo_bomba->ativo = $request->ativo;

                if ($modelo_bomba->save()) {
                    Session::flash('success', __('messages.update_success', [
                        'model' => __('modelo_bomba'),
                        'name' => $modelo_bomba->modelo_bomba
                    ]));
                    return redirect()->action('ModeloBombaController@index');
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
     * @param  \App\ModeloBomba  $modeloBomba
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModeloBomba $modeloBomba)
    {
        if (Auth::user()->canAlterarModeloBomba()) {
            try {
                if ($modelo_bomba->delete()) {
                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('modelo_bomba'),
                        'name' => $modelo_bomba->modelo_bomba
                    ]));
                    return redirect()->action('ModeloBombaController@index');
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
                return redirect()->action('ModeloBombaController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }
}
