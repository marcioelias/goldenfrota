<?php $__env->startSection('relatorio'); ?>
<table class="table table-condensed report-table">
    <thead>
        <tr class="info">
            <td>
                Id
            </td>
            <td>
                Cliente
            </td>
            <td>
                Departamento
            </td>
            <td>
                Grupo
            </td>
            <td>
                Placa
            </td>
            <td>
                Tag
            </td>
            <td>
                Marca
            </td>
            <td>
                Modelo
            </td>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $veiculos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $veiculo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
        <tr>
            <td>
                <?php echo e($veiculo->id); ?>

            </td>
            <td>
                <?php echo e($veiculo->nome_razao); ?>

            </td>
            <td>
                <?php echo e($veiculo->departamento); ?>

            </td>
            <td>
                <?php echo e($veiculo->grupo_veiculo); ?>

            </td>
            <td>
                <?php echo e($veiculo->placa); ?>

            </td>
            <td>
                <?php echo e($veiculo->tag); ?>

            </td>
            <td>
                <?php echo e($veiculo->marca_veiculo); ?>

            </td>
            <td>
                <?php echo e($veiculo->modelo_veiculo); ?>

            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.relatorios', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>