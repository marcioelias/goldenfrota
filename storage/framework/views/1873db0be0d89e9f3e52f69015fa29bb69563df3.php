<?php $__env->startSection('content'); ?>
    <div class="panel panel-default">
        <?php $__env->startComponent('components.form', [
            'title' => 'Alterar Senha de Acesso', 
            'routeUrl' => route('user.change.password', $user->id), 
            'cancelRoute' => 'user.profile',
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
                            'field' => 'name',
                            'label' => 'Nome',
                            'required' => true,
                            'disabled' => true,
                            'inputSize' => 6,
                            'inputValue' => $user->name
                        ],
                        [
                            'type' => 'text',
                            'field' => 'email',
                            'label' => 'E-mail',
                            'required' => true,
                            'disabled' => true,
                            'inputSize' => 6,
                            'inputValue' => $user->email
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'password',
                            'field' => 'current_password',
                            'label' => 'Senha Atual',
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'password',
                            'field' => 'password',
                            'label' => 'Nova Senha',
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'password',
                            'field' => 'password_confirmation',
                            'label' => 'Confirmar Nova Senha',
                            'inputSize' => 4
                        ],
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
            <?php $__env->stopSection(); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>