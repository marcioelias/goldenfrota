<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.table', [
        'captions' => $fields, 
        'rows' => $abastecimentos, 
        'model' => 'abastecimento',
        'tableTitle' => 'Abastecimento',
        'displayField' => 'id',
        'actions' => ['edit', 'destroy'],
        'colorLineCondition' => [
            'field' => 'inconsistencias_importacao',
            'value' => '1',
            'class' => 'danger'
            ],
        'searchParms' => 'abastecimento.search_parms'
        ]); ?>;
    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>