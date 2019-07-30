<?php

namespace App\Http\Controllers;

use App\Veiculo;
use App\Cliente;
use App\Parametro;
use App\GrupoVeiculo;
use App\MarcaVeiculo;
use App\Departamento;
use App\ModeloVeiculo;
use App\Abastecimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Events\NovoRegistroAtualizacaoApp;
use App\AtualizacaoApp;

class VeiculoController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'placa' => 'Placa',
        'grupo_veiculo' => 'Grupo',
        'marca_veiculo' => 'Marca',
        'modelo_veiculo' => 'Modelo',
        'ano' => 'Ano',
        'nome_razao' => 'Cliente',
        'departamento' => 'Departamento',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        if (isset($request->searchField)) {
            $veiculos = DB::table('veiculos')
                            ->select('veiculos.*', 'marca_veiculos.marca_veiculo', 'modelo_veiculos.modelo_veiculo', 'clientes.nome_razao', 'grupo_veiculos.grupo_veiculo', 'departamentos.departamento')
                            ->join('modelo_veiculos', 'modelo_veiculos.id', 'veiculos.modelo_veiculo_id')
                            ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
                            ->join('clientes', 'clientes.id', 'veiculos.cliente_id')
                            ->join('grupo_veiculos', 'grupo_veiculos.id', 'veiculos.grupo_veiculo_id')
                            ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                            ->where('placa', 'like', '%'.$request->searchField.'%')
                            ->orWhere('tag', 'like', '%'.$request->searchField.'%')
                            ->orWhere('nome_razao', 'like', '%'.$request->searchField.'%')
                            ->orderBy('veiculos.id', 'desc')
                            ->paginate();   
        } else {
            $veiculos = DB::table('veiculos')
                            ->select('veiculos.*', 'marca_veiculos.marca_veiculo', 'modelo_veiculos.modelo_veiculo', 'clientes.nome_razao', 'grupo_veiculos.grupo_veiculo', 'departamentos.departamento')
                            ->join('modelo_veiculos', 'modelo_veiculos.id', 'veiculos.modelo_veiculo_id')
                            ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
                            ->join('clientes', 'clientes.id', 'veiculos.cliente_id')
                            ->join('grupo_veiculos', 'grupo_veiculos.id', 'veiculos.grupo_veiculo_id')
                            ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                            ->orderBy('veiculos.id', 'desc')
                            ->paginate();
        }

        return View('veiculo.index')->withVeiculos($veiculos)->withFields($this->fields);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marcaVeiculos = MarcaVeiculo::all();
        $grupoVeiculos = GrupoVeiculo::all();
        $clientes = Cliente::all();
        $departamentos = Departamento::all();

        return View('veiculo.create', [
            'marcaVeiculos' => $marcaVeiculos,
            'grupoVeiculos' => $grupoVeiculos,
            'clientes' => $clientes,
            'departamentos' => $departamentos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'grupo_veiculo_id' => 'required|integer|min:1',
            'cliente_id' => 'required',
            'placa' => 'required|formato_placa_de_veiculo',
            'marca_veiculo_id' => 'required',
            'modelo_veiculo_id' => 'required',
            'ano' => 'required|integer',
            'renavam' => 'nullable|integer',
            'hodometro' => 'required|integer',
            'media_minima' => 'required'
        ]);

        try {
            //dd($request->all());   
            $veiculo = new Veiculo;
            $veiculo->placa = strtoupper($request->placa);
            $veiculo->tag = $request->tag;
            $veiculo->grupo_veiculo_id = $request->grupo_veiculo_id;
            $veiculo->cliente_id = $request->cliente_id;
            $veiculo->departamento_id = $request->departamento_id;
            $veiculo->modelo_veiculo_id = $request->modelo_veiculo_id;
            $veiculo->ano = $request->ano;
            $veiculo->renavam = $request->renavam;
            $veiculo->chassi = $request->chassi;
            $veiculo->hodometro = $request->hodometro;
            $veiculo->media_minima = $request->media_minima;

            if ($veiculo->save()) {

                event(new NovoRegistroAtualizacaoApp($veiculo));

                Session::flash('success', 'Veiculo '.$veiculo->placa.' cadastrado com sucesso.');
                return redirect()->action('VeiculoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return Redirect::back()->withInput(Input::all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Veiculo  $veiculo
     * @return \Illuminate\Http\Response
     */
    public function show(Veiculo $veiculo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Veiculo  $veiculo
     * @return \Illuminate\Http\Response
     */
    public function edit(Veiculo $veiculo)
    {
        $marcaVeiculos = MarcaVeiculo::all();
        $grupoVeiculos = GrupoVeiculo::all();
        $clientes = Cliente::all();
        $veiculo = Veiculo::find($veiculo->id);
        $marcaVeiculo = ModeloVeiculo::find($veiculo->modelo_veiculo_id)->marca_veiculo_id;

        $modeloVeiculos = ModeloVeiculo::where('marca_veiculo_id', 
            ModeloVeiculo::find($veiculo->modelo_veiculo_id)->marca_veiculo_id
        )->get();

        $departamentos = Departamento::where('cliente_id', $veiculo->cliente_id)->get();

        return View('veiculo.edit', [
            'marcaVeiculos' => $marcaVeiculos,
            'clientes' => $clientes,
            'veiculo' => $veiculo,
            'modeloVeiculos' => $modeloVeiculos,
            'grupoVeiculos' => $grupoVeiculos,
            'departamentos' => $departamentos,
            'marcaVeiculo' => $marcaVeiculo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Veiculo  $veiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Veiculo $veiculo)
    {
        $this->validate($request, [
            'grupo_veiculo_id' => 'required',
            'cliente_id' => 'required',
            'placa' => 'required|formato_placa_de_veiculo|unique:veiculos,id,'.$veiculo->id,
            'marca_veiculo_id' => 'required',
            'modelo_veiculo_id' => 'required',
            'ano' => 'required|integer',
            'renavam' => 'nullable|integer',
            'hodometro' => 'required|integer',
            'media_minima' => 'required'
        ]);

        try {
            $veiculo = Veiculo::find($veiculo->id);
            $veiculo->placa = strtoupper($request->placa);
            $veiculo->tag = $request->tag;
            $veiculo->grupo_veiculo_id = $request->grupo_veiculo_id;
            $veiculo->cliente_id = $request->cliente_id;
            $veiculo->departamento_id = $request->departamento_id;
            $veiculo->modelo_veiculo_id = $request->modelo_veiculo_id;
            $veiculo->ano = $request->ano;
            $veiculo->renavam = $request->renavam;
            $veiculo->chassi = $request->chassi;
            $veiculo->hodometro = $request->hodometro;
            $veiculo->media_minima = $request->media_minima;
            $veiculo->ativo = $request->ativo;


            if ($veiculo->save()) {

                event(new NovoRegistroAtualizacaoApp($veiculo));

                Session::flash('success', 'Veiculo '.$veiculo->placa.' alterado com sucesso.');
                return redirect()->action('VeiculoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. '.$e->getMessage());
            return Redirect::back()->withInput(Input::all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Veiculo  $veiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Veiculo $veiculo)
    {
        try {
            $veiculo = Veiculo::find($veiculo->id);
            if ($veiculo->delete()) {

                event(new NovoRegistroAtualizacaoApp($veiculo, true));

                Session::flash('success', 'Veiculo '.$veiculo->placa.' removido com sucesso.');
                
                return redirect()->action('VeiculoController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Registro não pode ser excluído. '.$e->getMessage());
            return redirect()->action('VeiculoController@index');
        }
    }

    public function getVeiculosJson(Request $request) {
        if ($request->id > 0) {
            $whereCliente = 'cliente_id = '.$request->id;
        } else {
            $whereCliente = '1 = 1';
        }

        $veiculos = Veiculo::with('modelo_veiculo.tipo_controle_veiculo')
                        ->with('modelo_veiculo.marca_veiculo')
                        ->with('vencimento_produtos')
                        ->where('veiculos.ativo', true)
                        ->whereRaw($whereCliente)
                        ->orderBy('veiculos.placa', 'asc')
                        ->get();
        /* $veiculos = Veiculo::select('veiculos.*', 'marca_veiculos.marca_veiculo', 'modelo_veiculos.modelo_veiculo')
                    ->join('modelo_veiculos', 'modelo_veiculos.id', 'veiculos.modelo_veiculo_id')
                    ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
                    ->where('veiculos.ativo', true)
                    ->whereRaw($whereCliente)
                    ->get(); */

        return response()->json($veiculos);
    }

    public function getVeiculosDepartamentoJson(Request $request) {
        if ($request->id > 0) {
            $whereDepartamento = 'departamento_id = '.$request->id;
        } else {
            $whereDepartamento = '1 = 1';
        }

        if ($request->cliente_id > 0) {
            $whereCliente = 'cliente_id = '.$request->cliente_id;
        } else {
            $whereCliente = '1 = 1';
        }
                 

        $veiculos = Veiculo::select('veiculos.*', 'marca_veiculos.marca_veiculo', 'modelo_veiculos.modelo_veiculo')
                    ->join('modelo_veiculos', 'modelo_veiculos.id', 'veiculos.modelo_veiculo_id')
                    ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
                    ->where('veiculos.ativo', true)
                    ->whereRaw($whereDepartamento)
                    ->whereRaw($whereCliente)
                    ->get();

        return response()->json($veiculos);
    }

    public function relMediaConsumo() {
        $graficos = array();

        $veiculos = Veiculo::where('ativo', true)->get();

        foreach($veiculos as $veiculo) {
            $labels = array();
            $values = array();

            foreach($veiculo->abastecimentos as $abastecimento) {
                $labels[] = $abastecimento->km_veiculo.' Km';
                $values[] = $abastecimento->media_veiculo;
            }

 
            $graficos[] = Charts::create('area', 'highcharts')
                                ->title('Veículo: '.$veiculo->placa)
                                ->elementLabel('Média')
                                ->labels($labels)
                                ->values($values)
                                ->responsive(true);
        }

        return View('relatorios.veiculos.media_consumo')->withTitulo('Média Consumo')->withGraficos($graficos)->withParametro(Parametro::first());
    }

    public function listagemVeiculos(Request $request) {
        $parametros = array();        

        if ($request->cliente_id > 0) {
            $whereCliente = 'clientes.id = '.$request->cliente_id;
            array_push($parametros, 'Cliente: '.Cliente::find($request->cliente_id)->nome_razao);
        } else {
            $whereCliente = '1 = 1'; 
        }

        if ($request->departamento_id > 0) {
            $whereDepartamento = 'departamentos.id = '.$request->departamento_id;
            array_push($parametros, 'Departamento: '.Departamento::find($request->departamento_id)->departamento);
        } else {
            $whereDepartamento = '1 = 1'; 
        }

        if ($request->grupo_veiculo_id > 0) {
            $whereGrupo = 'grupo_veiculos.id = '.$request->grupo_veiculo_id;
            array_push($parametros, 'Grupo: '.GrupoVeiculo::find($request->grupo_veiculo_id)->grupo_veiculo);
        } else {
            $whereGrupo = '1 = 1'; 
        }

        switch ($request->ativo) {
            case 1:
                $whereStatus = 'veiculos.ativo = 1';
                array_push($parametros, 'Status: Ativo');
                break;
            case 0:
                $whereStatus = 'veiculos.ativo = 0';
                array_push($parametros, 'Status: Desativado');
                break;
            default: 
                $whereStatus = '1 = 1';
                break;
        }

        $veiculos = Veiculo::select('veiculos.*', 'clientes.nome_razao', 'departamentos.departamento', 'grupo_veiculos.grupo_veiculo', 'modelo_veiculos.modelo_veiculo', 'marca_veiculos.marca_veiculo')
                        ->leftjoin('grupo_veiculos', 'grupo_veiculos.id', 'veiculos.grupo_veiculo_id')
                        ->leftJoin('clientes', 'clientes.id', 'veiculos.cliente_id')
                        ->leftJoin('departamentos', 'departamentos.id', 'veiculos.departamento_id')
                        ->leftJoin('modelo_veiculos', 'modelo_veiculos.id', 'veiculos.modelo_veiculo_id')
                        ->leftJoin('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
                        ->whereRaw($whereStatus)
                        ->whereRaw($whereCliente)
                        ->whereRaw($whereGrupo)
                        ->whereRaw($whereDepartamento)
                        ->orderBy('clientes.nome_razao', 'asc')
                        ->orderBy('departamentos.departamento', 'asc')
                        ->orderBy('grupo_veiculos.grupo_veiculo', 'asc')
                        ->orderBy('veiculos.placa', 'asc')
                        ->get();

        return View('relatorios.veiculos.listagem_veiculos')->withVeiculos($veiculos)->withParametros($parametros)->withTitulo('Listagem de Veículos')->withParametro(Parametro::first());
    }

    public function parametrosListagemVeiculos() {
        $clientes = Cliente::where('ativo', true)->orderBy('nome_razao', 'asc')->get();
        $grupo_veiculos = GrupoVeiculo::where('ativo', true)->orderBy('grupo_veiculo', 'asc')->get();

        return View('veiculo.listagem_veiculo_param', [
            'clientes' => $clientes,
            'grupo_veiculos' => $grupo_veiculos
        ]);
    }

    public function obterKmAbasteciemntoAnterior(Request $request) {
        /* $abastecimento = Abastecimento::select('km_veiculo')
                            ->where('abastecimentos.veiculo_id', $request->veiculo_id)
                            ->where('abastecimentos.id', '<', $request->id)
                            ->orderBy('abastecimentos.id', 'asc')
                            ->first();
                                
        return response()->json($abastecimento); */
        return response()->json(Abastecimento::select('km_veiculo')->ultimoDoVeiculo($request->veiculo_id, $request->id));
    }

    public function relatorioMediaModeloParam() {
        $marcaVeiculos = MarcaVeiculo::where('ativo', true)
                            ->orderBy('marca_veiculo', 'asc')
                            ->get();
        return View('relatorios.veiculos.media_modelo_veiculo_param', [
            'marcaVeiculos' => $marcaVeiculos
        ]);
    }

    public function relatorioMediaModelo(Request $request) {
        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $parametros = array();

        if($data_inicial && $data_final) {
            $whereData = 'abastecimentos.data_hora_abastecimento between \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial.'00:00:00'), 'Y-m-d H:i:s').'\' and \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_final.'23:59:59'), 'Y-m-d H:i:s').'\'';
            array_push($parametros, 'Período de '.$data_inicial.' até '.$data_final);
        } elseif ($data_inicial) {
            $whereData = 'abastecimentos.data_hora_abastecimento >= \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial.'00:00:00'), 'Y-m-d H:i:s').'\'';
            array_push($parametros, 'A partir de '.$data_inicial);
        } elseif ($data_final) {
            $whereData = 'abastecimentos.data_hora_abastecimento <= \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_final.'23:59:59'), 'Y-m-d H:i:s').'\'';
            array_push($parametros, 'Até '.$data_final);
        } else {
            $whereData = '1 = 1'; //busca qualquer coisa
        }

        if ($request->marca_veiculo_id > 0) {
            array_push($parametros, 'Marca: '.MarcaVeiculo::find($request->marca_veiculo_id)->marca_veiculo);
            $whereMarca = 'marca_veiculo_id = '.$request->marca_veiculo_id;
        } else {
            $whereMarca = '1 = 1';
        }

        if ($request->modelo_veiculo_id > 0) {
            array_push($parametros, 'Modelo: '.ModeloVeiculo::find($request->modelo_veiculo_id)->modelo_veiculo);
            $whereModelo = 'modelo_veiculo_id = '.$request->modelo_veiculo_id;
        } else {
            $whereModelo = '1 = 1';
        }

        //dd($request);

        $modeloVeiculos = Abastecimento::select('marca_veiculos.marca_veiculo', 'modelo_veiculos.id', 'modelo_veiculos.modelo_veiculo')
                            ->join('veiculos', 'veiculos.id', 'abastecimentos.veiculo_id')
                            ->join('modelo_veiculos', 'modelo_veiculos.id', 'veiculos.modelo_veiculo_id')
                            ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
                            ->whereRaw($whereData)
                            ->whereRaw($whereMarca)
                            ->whereRaw($whereModelo)
                            ->distinct()
                            ->orderBy('marca_veiculo', 'asc')
                            ->orderBy('modelo_veiculo', 'asc')
                            ->get();

        foreach ($modeloVeiculos as $modeloVeiculo) {
            
        }
    }

    public function apiIndex() {
        return response()->json(
            Veiculo::with('modelo_veiculo.marca_veiculo')
                ->Ativo()
                ->get()
        );
    }

    public function apiVeiculos() {
        return response()->json(Veiculo::ativo()->get());
    }

    public function apiVeiculo($id) {
        return response()->json(Veiculo::ativo()->where('id', $id)->get());
    }
}
