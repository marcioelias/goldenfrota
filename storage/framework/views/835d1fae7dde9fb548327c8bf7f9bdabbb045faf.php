

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.table', [
        'captions' => $fields, 
        'rows' => $grupoProdutos, 
        'model' => 'grupo_produto',
        'tableTitle' => 'Grupo de Produto',
        'displayField' => 'grupo_produto',
        'actions' => ['edit', 'destroy']
        ]); ?>;
    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>