

<?php $__env->startSection('content'); ?>
<?php if(old('fornecedores')): ?> 
    
<?php endif; ?>
    <div class="panel panel-default">
        <?php $__env->startComponent('components.form', [
            'title' => 'Novo Produto', 
            'routeUrl' => route('produto.store'), 
            'method' => 'POST',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Salvar', 'icon' => 'ok'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'remove']
                ]
            ]); ?>
            <?php $__env->startSection('formFields'); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'produto_descricao',
                            'label' => 'Descrição',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 6
                        ],
                        [
                            'type' => 'text',
                            'field' => 'produto_desc_red',
                            'label' => 'Descrição Reduzida',
                            'inputSize' => 2
                        ],
                        [
                            'type' => 'select',
                            'field' => 'grupo_produto_id',
                            'label' => 'Grupo',
                            'required' => true,
                            'items' => $grupoProdutos,
                            'inputSize' => 4,
                            'displayField' => 'grupo_produto',
                            'keyField' => 'id',
                            'liveSearch' => true,
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'unidade_id',
                            'label' => 'Unidade',
                            'required' => true,
                            'items' => $unidades,
                            'inputSize' => 4,
                            'displayField' => 'unidade',
                            'keyField' => 'id',
                            'liveSearch' => true,
                        ],
                        [
                            'type' => 'text',
                            'field' => 'valor_custo',
                            'label' => 'Preço de Custo',
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'text',
                            'field' => 'valor_venda',
                            'label' => 'Preço de Venda',
                            'inputSize' => 4
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'controla_vencimento',
                            'label' => 'Controla Vencimento',
                            'inputSize' => 4,
                            'items' => Array('Não', 'Sim'),
                        ],  
                        [
                            'type' => 'text',
                            'field' => 'vencimento_dias',
                            'label' => 'Vencimento em Dias',
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'text',
                            'field' => 'vencimento_km',
                            'label' => 'Vencimento em Km',
                            'inputSize' => 4
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'numero_serie',
                            'label' => 'Número de Série',
                            'inputSize' => 6
                        ],
                        [
                            'type' => 'text',
                            'field' => 'codigo_barras',
                            'label' => 'Código de Barras',
                            'inputSize' => 6
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <div class="row">
                    <div class="col-md-4">
                        <?php $__env->startComponent('components.input-checklist-group', [
                            'items' => $fornecedores,
                            'label' => 'nome_razao',
                            'field' => 'fornecedores[]',
                            'title' => 'Fornecedores',
                            'value' => 'id'
                        ]); ?>
                        <?php echo $__env->renderComponent(); ?>
                    </div>
                    <div class="col-md-8" id="estoqueProdutoComponent">
                          
                        <estoque_produto :estoques-data="<?php echo e(json_encode($listaEstoques)); ?>" :old-data="<?php echo e(json_encode(old('estoques'))); ?>"></estoque_produto>                      
                    </div>
                </div>
            <?php $__env->stopSection(); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>
<?php $__env->startPush('bottom-scripts'); ?>
    <script>
        jQuery(function($){
            $("#valor").mask('0.00', {reverse: true});
        });
    </script>
    <script src="<?php echo e(asset('js/estoqueproduto.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>