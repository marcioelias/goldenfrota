

<?php $__env->startSection('content'); ?>
    <div class="panel panel-default">
        <?php $__env->startComponent('components.form', [
            'title' => 'Nova Entrada no Estoque', 
            'routeUrl' => route('entrada_estoque.store'), 
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
                            'type' => 'number',
                            'field' => 'nr_docto',
                            'label' => 'Nr. Documento',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 3
                        ],
                        [
                            'type' => 'text',
                            'field' => 'serie',
                            'label' => 'Série',
                            'required' => true,
                            'inputSize' => 3
                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_doc',
                            'label' => 'Data Documento',
                            'required' => true,
                            'inputSize' => 3
                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_entrada',
                            'label' => 'Data Entrada',
                            'required' => true,
                            'inputSize' => 3
                        ],
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'fornecedor_id',
                            'label' => 'Fornecedor',
                            'required' => true,
                            'items' => $fornecedores,
                            'displayField' => 'nome_razao',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'inputSize' => 7
                        ],
                        [
                            'type' => 'select',
                            'field' => 'estoque_id',
                            'label' => 'Estoque',
                            'required' => true,
                            'items' => $estoques,
                            'displayField' => 'estoque',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'inputSize' => 5
                        ],
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <div id="entrada_estoque_produtos" class="<?php echo e($errors->has('items') ? ' has-error' : ''); ?>">
                    <entrada_estoque :produtos-data="<?php echo e(json_encode($produtos)); ?>" :old-data="<?php echo e(json_encode(old('items'))); ?>"></entrada_estoque>
                    <?php if($errors->has('items')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('items')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>

               
            <?php $__env->stopSection(); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>
<?php $__env->startPush('bottom-scripts'); ?>
    <script src="<?php echo e(asset('js/entradaestoque.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>