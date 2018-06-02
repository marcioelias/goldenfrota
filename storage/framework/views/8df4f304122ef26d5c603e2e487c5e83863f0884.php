

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.table', [
        'captions' => $fields, 
        'rows' => $tipoMovimentacaoProdutos, 
        'model' => 'tipo_movimentacao_produto',
        'tableTitle' => 'Tipo de Movimentação de Produtos',
        'displayField' => 'tipo_movimentacao_produto',
        'actions' => ['edit', 'destroy']
        ]); ?>;
    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>