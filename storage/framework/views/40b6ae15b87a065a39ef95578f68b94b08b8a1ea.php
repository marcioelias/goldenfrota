

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.table', [
        'captions' => $fields, 
        'rows' => $entradas, 
        'model' => 'entrada_estoque',
        'tableTitle' => 'Entradas no Estoque',
        'displayField' => 'nr_docto',
        'actions' => ['edit', 'destroy']
        ]); ?>;
    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>