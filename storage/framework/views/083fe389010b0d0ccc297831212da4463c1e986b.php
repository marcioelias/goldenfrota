

<?php $__env->startSection('content'); ?>
    <div class="panel panel-default">
        <?php $__env->startComponent('components.form', [
            'title' => 'Nova Bomba', 
            'routeUrl' => route('bomba.store'), 
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
                            'field' => 'descricao_bomba',
                            'label' => 'Bomba',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => isset($bomba->descricao_bomba) ? $bomba->descricao_bomba : '',
                            'inputSize' => 6
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'tipo_bomba_id',
                            'label' => 'Tipo de Bomba',
                            'required' => true,
                            'items' => $tipoBombas,
                            'inputSize' => 6,
                            'displayField' => 'tipo_bomba',
                            'keyField' => 'id',
                            'indexSelected' => isset($bomba->tipo_bomba_id) ? $bomba->tipo_bomba_id : ''
                        ],
                        [
                            'type' => 'select',
                            'field' => 'modelo_bomba_id',
                            'label' => 'Modelo de Bomba',
                            'required' => true,
                            'items' => $modeloBombas,
                            'inputSize' => 6,
                            'displayField' => 'modelo_bomba',
                            'keyField' => 'id',
                            'indexSelected' => isset($bomba->modelo_bomba_id) ? $bomba->modelo_bomba_id : ''
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
            <?php $__env->stopSection(); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>