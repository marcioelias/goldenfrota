

<?php $__env->startSection('content'); ?>
    <div class="panel panel-default">
        <?php $__env->startComponent('components.form', [
            'title' => 'Alterar Inventário', 
            'routeUrl' => route('inventario.update', $inventario->id), 
            'method' => 'PUT',
            'formButtons' => [
                //['type' => 'button', 'label' => 'Salvar', 'icon' => 'floppy-save'],
                ['type' => 'submit', 'label' => 'Salvar', 'icon' => 'ok'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'remove']
                ]
            ]); ?>
            <?php $__env->startSection('formFields'); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'id',
                            'label' => 'ID',
                            'disabled' => true,
                            'inputValue' => $inventario->id,
                            'inputSize' => 1
                        ],
                        [
                            'type' => 'text',
                            'field' => 'estoque',
                            'label' => 'Estoque',
                            'disabled' => true,
                            'inputValue' => $inventario->estoque->estoque,
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_abertura',
                            'label' => 'Data Abertura',
                            'disabled' => true,
                            'inputValue' => $inventario->data_abertura,
                            'inputSize' => 3
                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_fechamento',
                            'label' => 'Data Fechamento',
                            'disabled' => true,
                            'inputValue' => $inventario->data_fechamento,
                            'inputSize' => 3
                        ],
                        [
                            'type' => 'select',
                            'field' => 'fechado',
                            'label' => 'Fechado',
                            'inputSize' => 1,
                            'indexSelected' => $inventario->fechado,
                            'items' => Array('Não', 'Sim'),
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-xs-1 col-sm-1 col-md-1">ID</div>
                            <div class="col col-xs-7 col-sm-7 col-md-9">Produto</div>
                            <div class="col col-xs-4 col-sm-4 col-md-2">Qtd Contada</div>
                        </div>
                    </div>
                    <div class="panel-body" style="padding: 0px 15px !important">
                        <?php $__currentLoopData = $inventario->inventario_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row <?php echo e(($key % 2 == 0) ? 'bg-info' : 'bg-warning'); ?>">
                            <div class="col col-xs-1 col-sm-1 col-md-1" style="padding-top: 3px"><?php echo e($item->produto->id); ?></div>
                            <div class="col col-xs-7 col-sm-7 col-md-9" style="padding-top: 3px"><?php echo e($item->produto->produto_descricao); ?></div>
                            <div class="col col-xs-4 col-sm-4 col-md-2">
                                <?php
                                    $contado = (old('items[$item->id][qtd_contada]')) ? old('items[$item->id][qtd_contada]') : $item->qtd_contada;
                                    if ($contado < 0) {
                                        $contado = '';
                                    }
                                ?>
                                <input type="text" class="form-control input-sm" name="items[<?php echo e($item->id); ?>][qtd_contada]" value="<?php echo e($contado); ?>" >
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php $__env->stopSection(); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>