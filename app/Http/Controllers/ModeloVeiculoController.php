<?php

namespace App\Http\Controllers;

use App\MarcaVeiculo;
use App\ModeloVeiculo;
use App\TipoControleVeiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Events\NovoRegistroAtualizacaoApp;
use App\Traits\SearchTrait;

class ModeloVeiculoController extends Controller
{

    use SearchTrait;

    public $fields = array(
        'modelo_veiculos.id' => ['label' => 'ID', 'type' => 'int', 'searchParam' => true],
        'marca_veiculo' => ['label' => 'Marca', 'type' => 'string', 'searchParam' => true],
        'modelo_veiculo' => ['label' => 'Modelo', 'type' => 'string', 'searchParam' => true],
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        if (Auth::user()->canListarModeloVeiculo()) {
            if ($request->searchField) {
                $whereRaw = $this->getWhereField($request, $this->fields);
                $modeloVeiculos = DB::table('modelo_veiculos')
                                    ->select('modelo_veiculos.*', 'marca_veiculos.marca_veiculo')
                                    ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
                                    ->whereRaw($whereRaw)
                                    ->paginate();
            } else {
                $modeloVeiculos = DB::table('modelo_veiculos')
                ->select('modelo_veiculos.*', 'marca_veiculos.marca_veiculo')
                ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
                ->paginate();
            }

            return View('modelo_veiculo.index', [
                'modeloVeiculos' => $modeloVeiculos,
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
        if (Auth::user()->canCadastrarModeloVeiculo()) {
            return View('modelo_veiculo.create', [
                'marcaVeiculos' => MarcaVeiculo::all(),
                'tipoControleVeiculos' => TipoControleVeiculo::all(),
            ]);
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
        if (Auth::user()->canCadastrarModeloVeiculo()) {
            $this->validate($request, [
                'modelo_veiculo' => 'required|string|min:3|max:30|unique:modelo_veiculos',
                'marca_veiculo_id' => 'required|integer|exists:marca_veiculos,id',
                'capacidade_tanque' => 'required|integer|min:0'
            ]);

            try {
                $modeloVeiculo = new ModeloVeiculo($request->all());

                if ($modeloVeiculo->save()) {

                    event(new NovoRegistroAtualizacaoApp($modeloVeiculo));

                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.modelo_veiculo'),
                        'name' => $modeloVeiculo->modelo_veiculo
                    ]));
                    return redirect()->action('ModeloVeiculoController@index', $request->query->all() ?? []);
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
     * @param  \App\ModeloVeiculo  $modeloVeiculo
     * @return \Illuminate\Http\Response
     */
    public function edit(ModeloVeiculo $modeloVeiculo)
    {
        if (Auth::user()->canAlterarModeloVeiculo()) {
            return View('modelo_veiculo.edit', [
                'marcaVeiculos' => MarcaVeiculo::all(),
                'tipoControleVeiculos' => TipoControleVeiculo::all(),
                'modeloVeiculo' => $modeloVeiculo
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
     * @param  \App\ModeloVeiculo  $modeloVeiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModeloVeiculo $modeloVeiculo)
    {
        if (Auth::user()->canAlterarModeloVeiculo()) {
            $this->validate($request, [
                'modelo_veiculo' => 'required|string|min:3|max:30|unique:modelo_veiculos,id,'.$modeloVeiculo->id,
                'marca_veiculo_id' => 'required|integer|exists:marca_veiculos,id',
                'capacidade_tanque' => 'required|integer|min:0'
            ]);

            try {
                $modeloVeiculo->fill($request->all());

                if ($modeloVeiculo->save()) {

                    event(new NovoRegistroAtualizacaoApp($modeloVeiculo));

                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.modelo_veiculo'),
                        'name' => $modeloVeiculo->modelo_veiculo
                    ]));
                    return redirect()->action('ModeloVeiculoController@index', $request->query->all() ?? []);
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
     * @param  \App\ModeloVeiculo  $modeloVeiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ModeloVeiculo $modeloVeiculo)
    {
        if (Auth::user()->canExcluirModeloVeiculo()) {
            try {
                if ($modeloVeiculo->delete()) {

                    event(new NovoRegistroAtualizacaoApp($modeloVeiculo, true));

                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.modelo_veiculo'),
                        'name' => $modeloVeiculo->modelo_veiculo
                    ]));
                    return redirect()->action('ModeloVeiculoController@index', $request->query->all() ?? []);
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
                return redirect()->action('ModeloVeiculoController@index', $request->query->all() ?? []);
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function getModelosJson(Request $request) {
        $modeloVeiculos = ModeloVeiculo::where('marca_veiculo_id', $request->id)->get();

        return response()->json($modeloVeiculos);
    }

    public function apiModeloVeiculos() {
        return response()->json(ModeloVeiculo::ativo()->get());
    }

    public function apiModeloVeiculo($id) {
        return response()->json(ModeloVeiculo::ativo()->where('id', $id)->get());
    }
}
