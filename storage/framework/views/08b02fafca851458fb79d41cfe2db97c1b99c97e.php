

<?php $__env->startSection('content'); ?>
<?php
    $menuItems = [
        [
            'url' => '/admin/empresa',
            'rotulo' => 'Empresas'
        ],
        [
            'url' => '/admin/departamento',
            'rotulo' => 'Departamentos'
        ],
        [
            'url' => '/admin/perfil',
            'rotulo' => 'Perfis'
        ],
        [
            'url' => '/admin/horario',
            'rotulo' => 'Horários'
        ],
        [
            'url' => '/admin/plantonista',
            'rotulo' => 'Plantonistas'
        ],
        [
            'url' => '/admin/plantao',
            'rotulo' => 'Plantões'
        ],
    ]
?>
    <?php $__env->startComponent('components.table', [
        'captions' => $fields, 
        'rows' => $tipo_bombas, 
        'model' => 'tipo_bomba',
        'tableTitle' => 'Tipo de Bomba',
        'displayField' => 'tipo_bomba',
        'actions' => ['edit', 'destroy']
        ]); ?>;
    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>