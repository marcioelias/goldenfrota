<?php

namespace App\Http\Controllers;

use App\PosicaoPneu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PosicaoPneuController extends Controller
{
    public $fields = [
        'id' => 'ID',
        'posicao_pneu' => 'Posição Pneu'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarPosicaoPneu()) {
            if ($request->searchField) {
                $posicoes = PosicaoPneu::where('posicao_pneu', 'like', '%'.$request->searchField.'%')->paginate();
            } else {
                $posicoes = PosicaoPneu::paginate();
            }

            return View('posicao_pneu.index', [
                'fields' => $this->fields,
                'posicoes' => $posicoes
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
        if (Auth::user()->canCadastrarPosicaoPneu()) {
            return View('posicao_pneu.create');
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
        if (Auth::user()->canCadastrarPosicaoPneu()) {
            try {
                $this->validate($request, [
                    'posicao_pneu' => 'required'
                ]);

                $posicaoPneu = new PosicaoPneu($request->all());

                if ($posicaoPneu->save()) {
                    Session::flash('success', __('messages.create_success_f', [
                        'model' => 'posicao_pneu',
                        'name' => $request->posicao_pneu
                    ]));

                    return redirect()->action('PosicaoPneuController@index');
                } else {
                    Session::flash('error', __('messages.create_error_f', [
                        'model' => 'posicao_pneu',
                        'name' => $request->posicao_pneu
                    ]));
                    return redirect()->back()->withInput();
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
     * Display the specified resource.
     *
     * @param  \App\PosicaoPneu  $posicaoPneu
     * @return \Illuminate\Http\Response
     */
    public function show(PosicaoPneu $posicaoPneu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PosicaoPneu  $posicaoPneu
     * @return \Illuminate\Http\Response
     */
    public function edit(PosicaoPneu $posicaoPneu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PosicaoPneu  $posicaoPneu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PosicaoPneu $posicaoPneu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PosicaoPneu  $posicaoPneu
     * @return \Illuminate\Http\Response
     */
    public function destroy(PosicaoPneu $posicaoPneu)
    {
        //
    }
}
