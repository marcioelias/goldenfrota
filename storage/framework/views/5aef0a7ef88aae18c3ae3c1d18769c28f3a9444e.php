<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                <img src="<?php echo e(asset('images/logo_golden.png')); ?>" alt="Golden Service - Controle de Frotas">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <?php if(auth()->guard()->check()): ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Produtos
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (app('laratrust')->can('listar-combustivel')) : ?>
                        <li><a href="<?php echo e(route('combustivel.index')); ?>">Combustíveis</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('listar-produto')) : ?>
                        <li><a href="<?php echo e(route('produto.index')); ?>">Produtos</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('listar-grupo-produto')) : ?>
                        <li><a href="<?php echo e(route('grupo_produto.index')); ?>">Grupos de Produto</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('listar-tipo-movimentacao-produto')) : ?>
                        <li><a href="<?php echo e(route('tipo_movimentacao_produto.index')); ?>">Tipo de Movimentação de Produto</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('listar-estoque')) : ?>
                        <li><a href="<?php echo e(route('estoque.index')); ?>">Estoques</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('listar-unidade')) : ?>
                        <li><a href="<?php echo e(route('unidade.index')); ?>">Unidades</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <li class="divider"></li>
                        <?php if (app('laratrust')->can('listar-entrada-estoque')) : ?>
                        <li><a href="<?php echo e(route('entrada_estoque.index')); ?>">Entradas no Estoque</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <li class="divider"></li>
                        <?php if (app('laratrust')->can('listar-tanque')) : ?>
                        <li><a href="<?php echo e(route('tanque.index')); ?>">Tanques</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('listar-bomba')) : ?>
                        <li><a href="<?php echo e(route('bomba.index')); ?>">Bombas</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('listar-bico')) : ?>
                        <li><a href="<?php echo e(route('bico.index')); ?>">Bicos</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <li class="divider"></li>
                        <?php if (app('laratrust')->can('listar-tipo-bomba')) : ?>
                        <li><a href="<?php echo e(route('tipo_bomba.index')); ?>">Tipos de Bomba</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('listar-modelo-bomba')) : ?>
                        <li><a href="<?php echo e(route('modelo_bomba.index')); ?>">Modelos de Bomba</a></li>
                        <?php endif; // app('laratrust')->can ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Veículos
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (app('laratrust')->can('listar-veiculo')) : ?>
                        <li><a href="<?php echo e(route('veiculo.index')); ?>">Veículos</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('listar-grupo-veiculo')) : ?>
                        <li><a href="<?php echo e(route('grupo_veiculo.index')); ?>">Grupos de Veículo</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <li class="divider"></li>
                        <?php if (app('laratrust')->can('listar-marca-veiculo')) : ?>
                        <li><a href="<?php echo e(route('marca_veiculo.index')); ?>">Marcas de Veículo</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('listar-modelo-veiculo')) : ?>
                        <li><a href="<?php echo e(route('modelo_veiculo.index')); ?>">Modelos de Veículo</a></li>
                        <?php endif; // app('laratrust')->can ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Pessoas
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (app('laratrust')->can('listar-atendente')) : ?>
                        <li><a href="<?php echo e(route('atendente.index')); ?>">Atendentes</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('listar-cliente')) : ?>
                        <li><a href="<?php echo e(route('cliente.index')); ?>">Clientes</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('listar-fornecedor')) : ?>
                        <li><a href="<?php echo e(route('fornecedor.index')); ?>">Fornecedores</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <li class="divider"></li>
                        <?php if (app('laratrust')->can('listar-departamento')) : ?>
                        <li><a href="<?php echo e(route('departamento.index')); ?>">Departamentos</a></li>
                        <?php endif; // app('laratrust')->can ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Movimentação
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (app('laratrust')->can('listar-abastecimento')) : ?>
                        <li><a href="<?php echo e(route('abastecimento.index')); ?>">Abastecimentos</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        
                        
                        
                        <?php if (app('laratrust')->can('listar-tanque-movimentacao')) : ?>
                        <li><a href="<?php echo e(route('tanque_movimentacao.index')); ?>">Entrada de Combustíveis</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <li class="divider"></li>
                        <?php if (app('laratrust')->can('listar-inventario')) : ?>
                        <li><a href="<?php echo e(route('inventario.index')); ?>">Inventários</a></li>
                        <?php endif; // app('laratrust')->can ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Relatórios
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (app('laratrust')->can('acesso-posicao-tanques-grafico')) : ?>
                        <li><a href="<?php echo e(route('relatorio_posicao_tanques')); ?>" target="_blank">Posição dos Tanques (Gráfico)</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('acesso-media-consumo-veiculos-grafico')) : ?>
                        <li><a href="<?php echo e(route('relatorio_media_consumo')); ?>" target="_blank">Média de Consumo de Veículos (Gráfico)</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('acesso-listagem-clientes')) : ?>
                        <li><a href="<?php echo e(route('relatorio_listagem_clientes')); ?>" target="_blank">Listagem de Clientes</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('acesso-listagem-veiculos')) : ?>
                        <li><a href="<?php echo e(route('relatorio_listagem_veiculos')); ?>">Listagem de Veículos</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('acesso-listagem-tanques')) : ?>
                        <li><a href="<?php echo e(route('relatorio_listagem_tanques')); ?>" target="_blank">Listagem de Tanques</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('acesso-relatorio-abastecimentos')) : ?>
                        <li><a href="<?php echo e(route('param_relatorio_abastecimentos')); ?>">Relatório de Abastecimentos</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('acesso-relatorio-abastecimentos-bico')) : ?>
                        <li><a href="<?php echo e(route('param_relatorio_abastecimentos_bico')); ?>">Relatório de Abastecimentos - Bico</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('acesso-relatorio-media-consumo-modelo')) : ?>
                        <li><a href="<?php echo e(route('param_relatorio_media_modelo')); ?>">Relatório de Média de Consumo por Modelo</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <li class="divider"></li>
                        <?php if (app('laratrust')->can('acesso-relatorio-posicao-estoque')) : ?>
                        <li><a href="<?php echo e(route('param_relatorio_posicao_estoque')); ?>">Relatório de Posição de Estoque</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        
                        
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Automação
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (app('laratrust')->can('acesso-exportar-exportar-dados-cadastrais')) : ?>
                        <li><a href="<?php echo e(route('exportacao')); ?>">Exportar Dados Cadastrais</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('acesso-importar-abastecimentos')) : ?>
                        <li><a href="<?php echo e(route('importacao')); ?>">Importar Abastecimentos</a></li>
                        <?php endif; // app('laratrust')->can ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Controle de Acesso
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (app('laratrust')->can('listar-user')) : ?>
                        <li><a href="<?php echo e(route('user.index')); ?>">Usuários</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('listar-role')) : ?>
                        <li><a href="<?php echo e(route('role.index')); ?>">Perfis de Acesso</a></li>
                        <?php endif; // app('laratrust')->can ?>
                        <?php if (app('laratrust')->can('listar-role-user')) : ?>
                        <li><a href="<?php echo e(route('role_user.index')); ?>">Associação de Usuários e Perfis de Acesso</a></li>
                        <?php endif; // app('laratrust')->can ?>
                    </ul>
                </li>
                <?php else: ?>
                &nbsp;
                <?php endif; ?>
                
                </ul>
            </ul>

            <!-- Right Side Of Navbar -->
            <?php if(auth()->guard()->check()): ?>
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                
                    
                    
                
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="glyphicon glyphicon-user"></span>  <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo e(route('user.profile')); ?>"><i class="glyphicon glyphicon-cog"></i> Minha Conta</a></li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo e(route('logout')); ?>"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    <span class="glyphicon glyphicon-off"></span> Logout
                                </a>

                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                    <?php echo e(csrf_field()); ?>

                                </form>
                            </li>
                        </ul>
                    </li>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>

<?php $__env->startComponent('layouts.session_messages'); ?>
<?php echo $__env->renderComponent(); ?>