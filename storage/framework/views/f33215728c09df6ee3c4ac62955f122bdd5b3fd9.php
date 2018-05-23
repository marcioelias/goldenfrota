

<?php $__env->startSection('content'); ?>
    <div class="panel panel-default">
        <?php $__env->startComponent('components.form', [
            'title' => 'Alterar Unidade', 
            'routeUrl' => route('unidade.update', $unidade->id), 
            'method' => 'PUT',
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
                            'field' => 'unidade',
                            'label' => 'Unidade',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => $unidade->unidade,
                            'inputSize' => 8
                        ],
                        [
                            'type' => 'select',
                            'field' => 'permite_fracionamento',
                            'label' => 'Permite Fracionamento',
                            'inputSize' => 2,
                            'indexSelected' => $unidade->permite_fracionamento,
                            'items' => ['Não', 'Sim'],
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $unidade->ativo,
                            'items' => ['Não', 'Sim'],
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
            <?php $__env->stopSection(); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>