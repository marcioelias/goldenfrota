

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.table', [
        'captions' => $fields, 
        'rows' => $roleUsers, 
        'model' => 'role_user',
        'tableTitle' => 'Associação de Usuários e Perfis de Acesso',
        'displayField' => 'name',
        'actions' => ['edit', 'destroy'],
        ]); ?>;
    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>