<?php

namespace App\Http\Controllers;

use App\Combustivel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Session;
use App\Events\NovoRegistroAtualizacaoApp;
use App\Traits\SearchTrait;

class CombustivelController extends Controller
{

    use SearchTrait;

    public $fields = array(
        'id' => ['label' => 'ID', 'type' => 'int', 'searchParam' => true],
        'descricao' => ['label' => 'Combustível', 'type' => 'string', 'searchParam' => true],
        'valor' => ['label' => 'Valor', 'type' => 'decimal', 'decimais' => 3],
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarCombustivel()) {
            if (isset($request->searchField)) {
                $whereRaw = $this->getWhereField($request, $this->fields);
                $combustiveis = Combustivel::whereRaw($whereRaw)
                        ->paginate();
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
        if (Auth::user()->canCadastrarCombustivel()) {
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
        if (Auth::user()->canCadastrarCombustivel()) {
            $this->validate($request, [
                'descricao' => 'string|required|min:5|unique:combustiveis',
                'descricao_reduzida' => 'string|required|min:3|max:8|unique:combustiveis',
                'valor' => 'numeric|required'
            ]);

            try {
                $combustivel = new Combustivel($request->all());
                if ($combustivel->save()) {

                    event(new NovoRegistroAtualizacaoApp($combustivel));

                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.combustivel'),
                        'name' => $combustivel->descricao
                    ]));

                    return redirect()->action('CombustivelController@index', $request->query->all() ?? []);
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
        if (Auth::user()->canAlterarCombustivel()) {
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
        if (Auth::user()->canAlterarCombustivel()) {
            $this->validate($request, [
                'descricao' => 'required|string|min:5|unique:combustiveis,id,' . $combustivel->id,
                'descricao_reduzida' => 'required|string|min:3|max:8|unique:combustiveis,id,' . $combustivel->id,
                'valor' => 'required|numeric'
            ]);

            try {
                $combustivel->fill($request->all());

                if ($combustivel->save()) {

                    event(new NovoRegistroAtualizacaoApp($combustivel));

                    Session::flash('success', __('messages.update_success', [
                        'model' => 'combustivel',
                        'name' => $combustivel->descricao
                    ]));
                    return redirect()->action('CombustivelController@index', $request->query->all() ?? []);
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
    public function destroy(Request $request, Combustivel $combustivel)
    {
        if (Auth::user()->canExcluirCombustivel()) {
            try {
                if ($combustivel->delete()) {

                    event(new NovoRegistroAtualizacaoApp($combustivel, true));

                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.combustivel'),
                        'name' => $combustivel->descricao
                    ]));
                    return redirect()->action('CombustivelController@index', $request->query->all() ?? []);
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
                return redirect()->action('CombustivelController@index', $request->query->all() ?? []);
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function apiCombustiveis()
    {
        return response()->json(Combustivel::ativo()->get());
    }

    public function apiCombustivel($id)
    {
        return response()->json(Combustivel::ativo()->where('id', $id)->get());
    }
}
