<?php

namespace App\Http\Controllers;

use App\GrupoServico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GrupoServicoController extends Controller
{

    public $fields = [
        'id' => 'ID',
        'grupo_servico' => 'Descrição'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarGrupoServico()) {
            if ($request->searchField) {
                $grupoServicos = GrupoServico::where('grupo_servico', 'like', '%'.$request->searchField.'%')->paginate();
            } else {
                $grupoServicos = GrupoServico::paginate();
            }

            return View('grupo_servico.index', [
                'grupoServicos' => $grupoServicos,
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
        if (Auth::user()->canCadastrarGrupoServico()) {
            return View('grupo_servico.create');
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
        if (Auth::user()->canCadastrarGrupoServico()) {
            try {

                $grupoServico = new GrupoServico($request->all());

                if ($grupoServico->save()) {
                    Session::flash('success', __('messages.create_success', [
                        'model' => 'grupo_servico',
                        'field' => 'grupo_servico'
                    ]));

                    return redirect()->action('GrupoServicoController@index');
                } else {
                    Session::flash('error', __('messages.create_error', [
                        'model' => __('models.grupo_servico'),
                        'name' => $grupoServico->grupo_servico
                    ]));
                    return redirect()->back()->withInput();
                }
            } catch (\Exception $e) {
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return redirect()->back();
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GrupoServico  $grupoServico
     * @return \Illuminate\Http\Response
     */
    public function edit(GrupoServico $grupoServico)
    {
        if (Auth::user()->canAlterarGrupoServico()) {
            return View('grupo_servico.edit', [
                'grupoServico' => $grupoServico
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
     * @param  \App\GrupoServico  $grupoServico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GrupoServico $grupoServico)
    {
        if (Auth::user()->canCadastrarGrupoServico()) {
            try {

                $grupoServico->fill($request->all());

                if ($grupoServico->save()) {
                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.grupo_servico'),
                        'name' => $grupoServico->grupo_servico
                    ]));

                    return redirect()->action('GrupoServicoController@index');
                } else {
                    Session::flash('error', __('messages.update_error', [
                        'model' => 'grupo_servico',
                        'field' => 'grupo_servico'
                    ]));
                    return redirect()->back()->withInput();
                }
            } catch (\Exception $e) {
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return redirect()->back();
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GrupoServico  $grupoServico
     * @return \Illuminate\Http\Response
     */
    public function destroy(GrupoServico $grupoServico)
    {
        if (Auth::user()->canExcluirGrupoServico()) {
            try {
                if ($grupoServico->delete()) {
                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.grupo_servico'),
                        'name' => $grupoServico->grupo_servico
                    ]));
                    return redirect()->action('GrupoServicoController@index');
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
                return redirect()->action('GrupoServicoController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        } 
    }
}
