<?php

namespace App\Http\Controllers;

use App\Bomba;
use App\TipoBomba;
use App\ModeloBomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BombaController extends Controller
{
    protected $fields = array(
        'id' => 'ID',
        'descricao_bomba' => 'Bomba',
        'tipo_bomba' => 'Tipo de Bomba',
        'modelo_bomba' => 'Modelo de Bomba',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarBomba()) {
            if (isset($request->searchField)) {
                $bombas = DB::table('bombas')
                                ->select('bombas.*', 'tipo_bombas.tipo_bomba', 'modelo_bombas.modelo_bomba')
                                ->join('tipo_bombas', 'tipo_bombas.id', 'bombas.tipo_bomba_id')
                                ->join('modelo_bombas', 'modelo_bombas.id', 'bombas.modelo_bomba_id')
                                ->where('descricao_bomba', 'like', '%'.$request->searchField.'%')
                                ->paginate();
            } else {
                $bombas = DB::table('bombas')
                                ->select('bombas.*', 'tipo_bombas.tipo_bomba', 'modelo_bombas.modelo_bomba')
                                ->join('tipo_bombas', 'tipo_bombas.id', 'bombas.tipo_bomba_id')
                                ->join('modelo_bombas', 'modelo_bombas.id', 'bombas.modelo_bomba_id')
                                ->paginate();
            }

            return View('bomba.index')->withBombas($bombas)->withFields($this->fields);
        } else {
            Session::flasn('error', __('messages.access_denied'));
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
        if (Auth::user()->canCadastrarBomba()) {
            return View('bomba.create', [
                'tipoBombas' => TipoBomba::all(),
                'modeloBombas' => ModeloBomba::all()
            ]);
        } else {
            Session::flasn('error', __('messages.access_denied'));
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
        if (Auth::user()->canCadastrarBomba()) {
            $this->validate($request, [
                'descricao_bomba' => 'string|required|min:3|unique:bombas',
                'tipo_bomba_id' => 'numeric|required',
                'modelo_bomba_id' => 'numeric|required'            
            ]);

            try {
                $bomba = new Bomba($request->all());

                if ($bomba->save()) {
                    Session::flash('success', __('messages.create_success_f', [
                        'model' => __('models.bomba'),
                        'name' => $bomba->descricao_bomba
                    ]));
                    return redirect()->action('BombaController@index');
                } 
            } catch (\Exception $e) {
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return redirect()->back()->withInput();
            } 
        } else {
            Session::flasn('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bomba  $bomba
     * @return \Illuminate\Http\Response
     */
    public function edit(Bomba $bomba)
    {
        if (Auth::user()->canAlterarBomba()) {
            return View('bomba.edit', [
                'bomba' => $bomba,
                'tipoBombas' => TipoBomba::all(),
                'modeloBombas' => ModeloBomba::all()
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
     * @param  \App\Bomba  $bomba
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bomba $bomba)
    {
        if (Auth::user()->canAlterarBomba()) {
            $this->validate($request, [
                'descricao_bomba' => 'string|required|min:3|unique:bombas,id,'.$bomba->id,
                'tipo_bomba_id' => 'numeric|required',
                'modelo_bomba_id' => 'numeric|required'            
            ]);

            try {
                $bomba->descricao_bomba = $request->descricao_bomba;
                $bomba->modelo_bomba_id = $request->modelo_bomba_id;
                $bomba->tipo_bomba_id = $request->tipo_bomba_id;
                $bomba->ativo = $request->ativo;

                if ($bomba->save()) {
                    Session::flash('success', __('messages.update_success_f', [
                        'model' => __('models.bomba'),
                        'name' => $bomba->descricao_bomba
                    ]));
                    return redirect()->action('BombaController@index');
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
     * @param  \App\Bomba  $bomba
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bomba $bomba)
    {
        if (Auth::user()->canExcluirBomba()) {
            try {
                $bomba = Bomba::find($bomba->id);
                if ($bomba->delete()) {
                    Session::flash('success', __('messages.delete_success_f', [
                        'model' => __('models.bomba'),
                        'name' => $bomba->descricao_bomba
                    ]));
                    
                    return redirect()->action('BombaController@index');
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
                return redirect()->action('BombaController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }
}
