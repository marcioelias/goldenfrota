<?php

namespace App\Http\Controllers;

use App\OrdemServicoStatus;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrdemServicoStatusController extends Controller
{

    use SearchTrait;

    public $fields = [
        'id' => ['label' => 'ID', 'type' => 'int', 'searchParam' => true],
        'os_status' => ['label' => 'Status', 'type' => 'string', 'searchParam' => true],
        'em_aberto' => ['label' => 'Em aberto', 'type' => 'bool']
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        if (Auth::user()->canListarOrdemServicoStatus()) {
            if ($request->searchField) {
                $whereRaw = $this->getWhereField($request, $this->fields);
                $ordemServicoStatus = OrdemServicoStatus::whereRaw($whereRaw)
                                ->orderBy('id', 'asc')
                                ->paginate();
            } else {
                $ordemServicoStatus = OrdemServicoStatus::orderBy('id', 'asc')
                                ->paginate();
            }

            return View('ordem_servico_status.index', [
                'fields' => $this->fields,
                'ordem_servico_status' => $ordemServicoStatus
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
        if (Auth::user()->canCadastrarOrdemServicoStatus()) {
            return View('ordem_servico_status.create');
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
        if (Auth::user()->canCadastrarOrdemServicoStatus()) {
            $this->validate($request, [
                'os_status' => 'required|string|unique:ordem_servico_status'
            ]);

            try {
                $ordemServicoStatus = new OrdemServicoStatus($request->all());
                $ordemServicoStatus->save();

                Session::flash('success', __('messages.create_success', [
                    'model' => __('models.ordem_servico_status'),
                    'name' => $ordemServicoStatus->os_status
                ]));

                return redirect()->action('OrdemServicoStatusController@index', $request->query->all() ?? []);
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
     * @param  \App\OrdemServicoStatus  $ordemServicoStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(OrdemServicoStatus $ordemServicoStatus)
    {
        if (Auth::user()->canAlterarOrdemServicoStatus()) {
            return View('ordem_servico_status.edit', [
                'ordemServicoStatus' => $ordemServicoStatus
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
     * @param  \App\OrdemServicoStatus  $ordemServicoStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrdemServicoStatus $ordemServicoStatus)
    {
        if (Auth::user()->canAlterarOrdemServicoStatus()) {
            $this->validate($request, [
                'os_status' => 'required|string|unique:ordem_servico_status,id,'.$ordemServicoStatus->id
            ]);
            try {
                $ordemServicoStatus->fill($request->all());
                $ordemServicoStatus->save();

                Session::flash('success', __('messages.update_success', [
                    'model' => __('models.ordem_servico_status'),
                    'name' => $ordemServicoStatus->os_status
                ]));

                return redirect()->action('OrdemServicoStatusController@index', $request->query->all() ?? []);
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
     * @param  \App\OrdemServicoStatus  $ordemServicoStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, OrdemServicoStatus $ordemServicoStatus)
    {
        if (Auth::user()->canExcluirOrdemServicoStatus()) {   
            try {
                if ($ordemServicoStatus->delete()) {
                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.ordem_servico_status'),
                        'name' => $ordemServicoStatus->os_status
                    ]));
                    return redirect()->action('OrdemServicoStatusController@index', $request->query->all() ?? []);
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
                return redirect()->action('OrdemServicoStatusController@index', $request->query->all() ?? []);        
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }
}
