<?php

namespace App\Http\Controllers;

use App\Afericao;
use App\Abastecimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MovimentacaoCombustivelController;

class AfericaoController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Abastecimento $abastecimento)
    {
        if (Auth::user()->canCadastrarAfericao()) {
            /* verifica se o abastecimento já não está relacionado com uma aferição */
            if ($abastecimento->eh_afericao) {
                Session::flash('error', 'Já existe uma aferição relacionada a esse abastecimento');
                return redirect()->back();
            }
            if ($abastecimento->bico_id) {
                //carrega a view para salvar a aferição
                return View('afericao.create')->withAbastecimento($abastecimento);
            } else {
                //não é possível fazer aferição de abastecimentos sem o bico relacionado
                Session::flash('error', 'Não é possível criar uma aferição a partir de um abastecimento que não tenha um bico relacionado.');
                return redirect()->back();
            }
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
        if (Auth::user()->canCadastrarAfericao()) {
            $this->validate($request, [
                'abastecimento_id' => 'required'
            ]);

            DB::beginTransaction();

            try {
                
                $afericao = new Afericao($request->all());
                $afericao->user_id = Auth::user()->id;

                if ($afericao->save()) {

                    /* seta o abastecimento como sendo uma aferição */
                    $abastecimento = Abastecimento::find($afericao->abastecimento_id);
                    $abastecimento->eh_afericao = true;
                    $abastecimento->save();

                    /* altera a movimentacao referente ao abastecimento para referenciar a afericao */
                    if (!MovimentacaoCombustivelController::converterAbastecimentoEmAfericao($afericao)) {
                        throw new \Exception();
                    };

                    /* lança uma movimentacao de entrada - aferição */
                    if (!MovimentacaoCombustivelController::entradaAfericao($afericao)) {
                        throw new \Exception();
                    }

                    
                    DB::commit();

                    Session::flash('success', __('messages.create_success_f', [
                        'model' => 'afericao',
                        'name' => $afericao->id
                    ]));

                    return redirect()->action('AbastecimentoController@index');
                } else {
                    throw new \Exception(__('messages.create_error_f', [
                        'model' => 'afericao',
                        'name' => ''
                    ]));
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
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Afericao  $afericao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Afericao $afericao)
    {
        try {
            return $afericao->delete();
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
            return redirect()->action('AbastecimentoController@index');
        }
    }
}
