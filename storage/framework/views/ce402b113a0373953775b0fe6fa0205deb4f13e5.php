

<?php $__env->startSection('content'); ?>
    <div class="panel panel-default">
        <?php $__env->startComponent('components.form', [
            'title' => 'Novo Atendente', 
            'routeUrl' => route('atendente.store'), 
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
                            'field' => 'nome_atendente',
                            'label' => 'Nome',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => isset($atendente->nome_atendente) ? $atendente->nome_atendente : '',
                            'inputSize' => 6
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'usuario_atendente',
                            'label' => 'Usuário',
                            'required' => true,
                            'inputValue' => isset($atendente->usuario_atendente) ? $atendente->usuario_atendente : '',
                            'inputSize' => 6
                        ],
                        [
                            'type' => 'text',
                            'field' => 'senha_atendente',
                            'label' => 'Senha',
                            'required' => true,
                            'inputValue' => isset($atendente->senha_atendente) ? $atendente->senha_atendente : '',
                            'inputSize' => 6
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
            <?php $__env->stopSection(); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>