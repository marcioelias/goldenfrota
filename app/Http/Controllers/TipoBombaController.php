<?php

namespace App\Http\Controllers;

use App\TipoBomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TipoBombaController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'tipo_bomba' => 'Tipo Bomba',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarTipoBomba()) {
            if (isset($request->searchField)) {
                $tipo_bombas = TipoBomba::where('tipo_bomba', 'like', '%'.$request->searchField.'%')->paginate();
            } else {
                $tipo_bombas = TipoBomba::paginate();
            }
            return View('tipo_bomba.index', [
                'tipo_bombas' => $tipo_bombas,
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
        if (Auth::user()->canCadastrarTipoBomba()) {
            return View('tipo_bomba.create');
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
        if (Auth::user()->canCadastrarTipoBomba()) {
            $this->validate($request, [
                'tipo_bomba' => 'required|string|unique:tipo_bombas'
            ]);

            try {
                $tipo_bomba = new TipoBomba($request->all());
                if ($tipo_bomba->save()) {
                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.tipo_bomba'),
                        'name' => $tipo_bomba->tipo_bomba
                    ]));

                    return redirect()->action('TipoBombaController@index');
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
     * @param  \App\TipoBomba  $tipoBomba
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoBomba $tipoBomba)
    {
        if (Auth::user()->canAlterarTipoBomba()) {
            return View('tipo_bomba.edit', [
                'tipo_bomba' => $tipo_bomba
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
     * @param  \App\TipoBomba  $tipoBomba
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoBomba $tipoBomba)
    {
        if (Auth::user()->canAlterarTipoBomba()) {
            $this->validate($request, [
                'tipo_bomba' => 'required|string|unique:tipo_bombas,id,'.$tipoBomba->id
            ]);
            
            try {
                $tipo_bomba->tipo_bomba = $request->tipo_bomba;
                $tipo_bomba->ativo = $request->ativo;

                if ($tipo_bomba->save()) {
                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.tipo_bomba'),
                        'name' => $tipo_bomba->tipo_bomba
                    ]));

                    return redirect()->action('TipoBombaController@index');
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
     * @param  \App\TipoBomba  $tipoBomba
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoBomba $tipoBomba)
    {
        if (Auth::user()->canAlterarTipoBomba()) {
            try {
                if ($tipo_bomba->delete()) {
                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.tipo_bomba'),
                        'name' => $tipo_bomba->tipo_bomba
                    ]));
                    
                    return redirect()->action('TipoBombaController@index');
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
                return redirect()->action('TipoBombaController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }
}
