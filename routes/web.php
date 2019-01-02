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

Auth::routes();
Route::get('/teste', function() {
    return View('teste');
});

Route::middleware(['auth:web'])->group(function() {

    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/perfil', 'UserController@profile')->name('user.profile');
    Route::get('/alterar_senha', 'UserController@showChangePassword')->name('user.form.change.password');
    Route::put('/alterar_senha/{user}', 'UserController@changePassword')->name('user.change.password');

    Route::resource('/combustivel', 'CombustivelController')->except('show');
    Route::resource('/tipo_bomba', 'TipoBombaController')->except('show');
    Route::resource('/modelo_bomba', 'ModeloBombaController')->except('show');
    Route::resource('/tanque', 'TanqueController')->except('show');
    Route::resource('/bomba', 'BombaController')->except('show');
    Route::resource('/user', 'UserController')->except('show');
    Route::resource('/grupo_produto', 'GrupoProdutoController');
    Route::resource('/grupo_servico', 'GrupoServicoController');
    Route::resource('/unidade', 'UnidadeController')->except('show');
    Route::resource('/produto', 'ProdutoController')->except('show');
    Route::resource('/bico', 'BicoController')->except('show');
    Route::resource('/marca_veiculo', 'MarcaVeiculoController')->except('show');
    Route::resource('/modelo_veiculo', 'ModeloVeiculoController')->except('show');
    Route::resource('/cliente', 'ClienteController')->except('show');
    Route::resource('/veiculo', 'VeiculoController')->except('show');
    Route::resource('/grupo_veiculo', 'GrupoVeiculoController')->except('show');
    Route::resource('/atendente', 'AtendenteController')->except('show');
    Route::resource('/abastecimento', 'AbastecimentoController')->except('show');
    Route::resource('/tanque_movimentacao', 'TanqueMovimentacaoController')->except('show');
    Route::resource('/departamento', 'DepartamentoController')->except('show');
    Route::resource('/fornecedor', 'FornecedorController')->except('show');
    Route::resource('/estoque', 'EstoqueController')->except('show');
    Route::resource('/parametro', 'ParametroController')->except('show');
    Route::resource('/tipo_movimentacao_produto', 'TipoMovimentacaoProdutoController')->except('show');
    Route::resource('/entrada_estoque', 'EntradaEstoqueController');
    Route::resource('/entrada_tanque', 'EntradaTanqueController');
    Route::resource('/saida_estoque', 'SaidaEstoqueController')->except(['edit', 'update']);
    Route::resource('/inventario', 'InventarioController');
    Route::resource('/posicao_pneu', 'PosicaoPneuController')->except(['show']);
    Route::resource('/servico', 'ServicoController')->except(['show']);
    Route::resource('/ordem_servico', 'OrdemServicoController');
    Route::resource('/ajuste_tanque', 'AjusteTanqueController')->except(['show', 'edit']);

    Route::resource('/role_user', 'RoleUsersController')->except('show');
    Route::resource('/role', 'RolesController')->except('show');

    /* Route::get('/parametro', 'ParametroController@index')->name('parametro.index');
    Route::post('/parametro', 'ParametroController@store')->name('parametro.store');
    Route::put('/parametro/{parametro}', 'ParametroController@update')->name('parametro.update'); */


    Route::get('/exportacao', 'IntegracaoAutomacaoController@Exportar')->name('exportacao');
    Route::get('/importacao', 'IntegracaoAutomacaoController@ImportarAbastecimentos')->name('importacao');

    Route::post('modelo_veiculo/json', 'ModeloVeiculoController@getModelosJson')->name('modelo_veiculos.json');
    Route::post('departamento/json', 'DepartamentoController@getDepartamentosJson')->name('departamentos.json');
    Route::post('veiculo/json', 'VeiculoController@getVeiculosJson')->name('veiculos.json');
    Route::post('bico/json', 'BicoController@getBicoJson')->name('bico.json');
    Route::post('veiculo_departamento/json', 'VeiculoController@getVeiculosDepartamentoJson')->name('veiculos_departamento.json');
    Route::post('tanques/json', 'TanqueController@getTanquesJson')->name('tanques.json');
    Route::post('ultimo_abastecimento/json', 'VeiculoController@obterKmAbasteciemntoAnterior')->name('ultimo_abastecimento.json');
    Route::post('grupo_produto/json', 'GrupoProdutoController@getGrupoProdutoJson')->name('grupo_produto.json');
    Route::post('produto_pelo_grupo/json', 'ProdutoController@obterProdutosPeloGrupo')->name('produtos_pelo_grupo.json');
    Route::get('produtos_estoque/{estoqueId}/json', 'ProdutoController@obterProdutosPeloEstoque')->name('produto_pelo_estoque');
    Route::get('posicao_estoque_produto/{produtoId}', 'MovimentacaoProdutoController@posicaoEstoqueProduto')->name('posicao_estoque_produto');

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
    Route::get('relatorios/posicao_estoque', 'MovimentacaoProdutoController@paramRelatorioPosicaoEstoque')->name('param_relatorio_posicao_estoque');
    Route::post('relatorios/posicao_estoque', 'MovimentacaoProdutoController@relatorioPosicaoEstoque')->name('relatorio_posicao_estoque');
    Route::get('relatorios/estoque_minimo', 'MovimentacaoProdutoController@paramRelatorioEstoqueMinimo')->name('param_relatorio_estoque_minimo');
    Route::post('relatorios/estoque_minimo', 'MovimentacaoProdutoController@relatorioEstoqueMinimo')->name('relatorio_estoque_minimo');
    Route::get('relatorios/movimentacao_produto', 'MovimentacaoProdutoController@paramRelatorioMovimetacaoEstoque')->name('param_relatorio_movimentacao_estoque');
    Route::post('relatorios/movimentacao_produto', 'MovimentacaoProdutoController@relatorioMovimentacaoEstoque')->name('relatorio_movimentacao_estoque');

    Route::get('setting', 'SettingController@index')->name('setting.index');
    Route::put('setting', 'SettingController@update')->name('setting.update');
    Route::get('afericao/{abastecimento}', 'AfericaoController@create')->name('afericao.create');
    Route::post('afericao', 'AfericaoController@store')->name('afericao.store');
});

Route::get('teste/{estoque}', 'GrupoProdutoController@getGrupoProdutoJson');

/* Route::get('relatorios/abastecimentos/imprimir', 'AbastecimentoController@gerarPdfRelatorioAbastecimentos')->name('imprimir_relatorio_abastecimentos'); */
/* 
Route::get('teste', 'IntegracaoAutomacaoController@configFTP')->name('teste');

Route::get('g', 'TanqueController@relPosicaoTanque');
 */