<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return view('/');
}); */

Auth::routes();

Route::middleware(['auth:web'])->group(function() {

    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/perfil', 'UserController@profile')->name('user.profile');
    Route::get('/alterar_senha', 'UserController@showChangePassword')->name('user.form.change.password');
    Route::put('/alterar_senha/{user}', 'UserController@changePassword')->name('user.change.password');

    Route::resource('/combustivel', 'CombustivelController');
    Route::resource('/tipo_bomba', 'TipoBombaController');
    Route::resource('/modelo_bomba', 'ModeloBombaController');
    Route::resource('/tanque', 'TanqueController');
    Route::resource('/bomba', 'BombaController');
    Route::resource('/user', 'UserController')->except('show');
    Route::resource('/grupo_produto', 'GrupoProdutoController');
    Route::resource('/unidade', 'UnidadeController');
    Route::resource('/produto', 'ProdutoController');
    Route::resource('/bico', 'BicoController');
    Route::resource('/marca_veiculo', 'MarcaVeiculoController');
    Route::resource('/modelo_veiculo', 'ModeloVeiculoController');
    Route::resource('/cliente', 'ClienteController');
    Route::resource('/veiculo', 'VeiculoController');
    Route::resource('/grupo_veiculo', 'GrupoVeiculoController');
    Route::resource('/atendente', 'AtendenteController')->except('show');
    Route::resource('/abastecimento', 'AbastecimentoController')->except('show');
    Route::resource('/tanque_movimentacao', 'TanqueMovimentacaoController');
    Route::resource('/departamento', 'DepartamentoController');
    Route::resource('/parametro', 'ParametroController');

    Route::resource('/role_user', 'RoleUsersController');
    Route::resource('/role', 'RolesController');

    /* Route::get('/parametro', 'ParametroController@index')->name('parametro.index');
    Route::post('/parametro', 'ParametroController@store')->name('parametro.store');
    Route::put('/parametro/{parametro}', 'ParametroController@update')->name('parametro.update'); */


    Route::get('/exportacao', 'IntegracaoAutomacaoController@Exportar')->name('exportacao');
    Route::get('/importacao', 'IntegracaoAutomacaoController@ImportarAbastecimentos')->name('importacao');

    Route::post('modelo_veiculo/json', 'ModeloVeiculoController@getModelosJson')->name('modelo_veiculos.json');
    Route::post('departamento/json', 'DepartamentoController@getDepartamentosJson')->name('departamentos.json');
    Route::post('veiculo/json', 'VeiculoController@getVeiculosJson')->name('veiculos.json');
    Route::post('veiculo_departamento/json', 'VeiculoController@getVeiculosDepartamentoJson')->name('veiculos_departamento.json');
    Route::post('tanques/json', 'TanqueController@getTanquesJson')->name('tanques.json');
    Route::post('ultimo_abastecimento/json', 'VeiculoController@obterKmAbasteciemntoAnterior')->name('ultimo_abastecimento.json');

    //relatorios
    Route::get('relatorios/posicao_tanques', 'TanqueController@relPosicaoTanque')->name('relatorio_posicao_tanques');
    Route::get('relatorios/media_consumo', 'VeiculoController@relMediaConsumo')->name('relatorio_media_consumo');
    Route::get('relatorios/listagem_tanques', 'TanqueController@listagemTanques')->name('relatorio_listagem_tanques');
    Route::get('relatorios/listagem_veiculos', 'VeiculoController@parametrosListagemVeiculos')->name('relatorio_listagem_veiculos');
    Route::post('relatorios/listagem_veiculos', 'VeiculoController@listagemVeiculos')->name('relatorio_listagem_veiculos');
    Route::get('relatorios/listagem_clientes', 'ClienteController@listagemClientes')->name('relatorio_listagem_clientes');
    Route::get('relatorios/abastecimentos', 'AbastecimentoController@parametrosRelatorio')->name('param_relatorio_abastecimentos');
    Route::post('relatorios/abastecimentos', 'AbastecimentoController@relatorioAbastecimentos')->name('param_relatorio_abastecimentos');
    Route::get('relatorios/abastecimentos_bico', 'AbastecimentoController@relatorioAbastecimentosBicoParam')->name('param_relatorio_abastecimentos_bico');
    Route::post('relatorios/abastecimentos_bico', 'AbastecimentoController@relatorioAbastecimentosBico')->name('relatorio_abastecimentos_bico');
    Route::get('relatorios/media_modelo', 'VeiculoController@relatorioMediaModeloParam')->name('param_relatorio_media_modelo');
    Route::post('relatorios/media_modelo', 'VeiculoController@relatorioMediaModelo')->name('relatorio_media_modelo');
});

/* Route::get('relatorios/abastecimentos/imprimir', 'AbastecimentoController@gerarPdfRelatorioAbastecimentos')->name('imprimir_relatorio_abastecimentos'); */

Route::get('teste', 'IntegracaoAutomacaoController@teste')->name('teste');

Route::get('g', 'TanqueController@relPosicaoTanque');
