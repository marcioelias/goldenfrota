<?php

namespace App\Http\Controllers;

use App\Tanque;
use App\AjusteTanque;
use Illuminate\Http\Request;
use App\Rules\ValidarVolumeTanque;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\TanqueController;
use App\Http\Controllers\MovimentacaoCombustivelController;
use App\Traits\SearchTrait;

class AjusteTanqueController extends Controller
{
    use SearchTrait;

    public $fields = [
        'ajuste_tanques.id' => ['label' => 'ID', 'type' => 'int', 'searchParam' => true],
        'descricao_tanque' => ['label' => 'Tanque', 'type' => 'string', 'searchParam' => true],
        'descricao' => ['label' => 'Combustível', 'type' => 'string', 'searchParam' => true],
        'quantidade_informada' => [
            'label' => 'Qtd Medida',
            'type' => 'decimal',
            'decimais' => 3
        ],
        'users.name' => ['label' => 'Usuário', 'type' => 'string', 'searchParam' => true],
        'ajuste_tanques.created_at' => [
            'label' => 'Data', 
            'type' => 'datetime'
        ]
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarAjusteTanque()) {
            if ($request->searchField) {

                $whereRaw = $this->getWhereField($request, $this->fields);

                $ajustes = DB::table('ajuste_tanques')
                            ->select('ajuste_tanques.*', 'tanques.descricao_tanque', 'combustiveis.descricao', 'users.name') 
                            ->join('tanques', 'tanques.id', 'ajuste_tanques.tanque_id')
                            ->join('users', 'users.id', 'ajuste_tanques.user_id')
                            ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                            /* ->where('users.name', 'like', '%'.$request->searchField.'%')
                            ->orWhere('tanques.descricao_tanque', 'like', '%'.$request->searchField.'%')
                            ->orWhere('combustiveis.descricao', 'like', '%'.$request->searchField.'%') */
                            ->whereRaw($whereRaw)
                            ->orderBy('ajuste_tanques.created_at', 'desc')
                            ->paginate();
            } else {
                $ajustes = DB::table('ajuste_tanques')
                            ->select('ajuste_tanques.*', 'tanques.descricao_tanque', 'combustiveis.descricao', 'users.name') 
                            ->join('tanques', 'tanques.id', 'ajuste_tanques.tanque_id')
                            ->join('users', 'users.id', 'ajuste_tanques.user_id')
                            ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                            ->orderBy('ajuste_tanques.created_at', 'desc')
                            ->paginate();
            }

            return View('ajuste_tanque.index', [
                'fields' => $this->fields,
                'ajustes' => $ajustes
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
        if (Auth::user()->canCadastrarAjusteTanque()) {
            $tanques = Tanque::select('tanques.id', DB::raw('concat_ws(" - ", tanques.descricao_tanque, combustiveis.descricao) as tanque'))
                            ->join('combustiveis', 'combustiveis.id', 'tanques.combustivel_id')
                            ->where('tanques.ativo', true)
                            ->orderBy('tanques.descricao_tanque', 'asc')
                            ->get();

            return View('ajuste_tanque.create', [
                'tanques' => $tanques
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
        if (Auth::user()->canCadastrarAjusteTanque()) {
            $this->validate($request, [
                'tanque_id' => 'required',
                'quantidade_informada' => [
                    'required', 
                    'numeric', 
                    'min:0',
                    new ValidarVolumeTanque($request->tanque_id)
                ]
            ]);   
            
            try {
                DB::beginTransaction();

                $saldo_atual = TanqueController::getPosicaoEstoque(Tanque::find($request->tanque_id));
                $ajuste = [
                    'tanque_id' => $request->tanque_id,
                    'quantidade_informada' => $request->quantidade_informada,
                    'quantidade_ajuste' => $request->quantidade_informada - $saldo_atual
                ];

                $ajusteTanque = Auth::user()->ajuste_tanque()->create($ajuste);
                if (MovimentacaoCombustivelController::ajustarSaldoTanque($ajusteTanque)) {
                    
                    DB::commit();

                    Session::flash('success', __('messages.create_success', [
                        'model' => __('ajuste_estoque'),
                        'name' => $ajusteTanque->id
                    ]));

                    return redirect()->action('AjusteTanqueController@index', $request->query->all() ?? []);
                } else {
                    
                    DB::rollback();
                    
                    Session::flash('error', __('messages.create_error', [
                        'model' => __('ajuste_tanque'),
                        'name' => $ajusteTanque->id
                    ]));

                    return redirect()->back()->withInput();
                }
            } catch (\Exception $e) {

                DB::rollback();

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
     * @param  \App\AjusteTanque  $ajusteTanque
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AjusteTanque $ajusteTanque)
    {
        if (Auth::user()->canExcluirAjusteTanque()) {   
            try {
                if ($ajusteTanque->delete()) {
                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.ajuste_tanque'),
                        'name' => $ajusteTanque->id
                    ]));
                    return redirect()->action('AjusteTanqueController@index', $request->query->all() ?? []);
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
                return redirect()->action('AjusteTanqueController@index', $request->query->all() ?? []);
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }
}
