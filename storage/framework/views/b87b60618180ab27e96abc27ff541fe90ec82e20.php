

<?php $__env->startSection('relatorio'); ?>
<table class="table table-condensed report-table">
    <thead>
        <tr class="info">
            <td>
                Id
            </td>
            <td>
                Descrição
            </td>
            <td>
                Combustível
            </td>
            <td>
                Capacidade
            </td>
            <td>
                Posição
            </td>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $tanques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tanque): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
        <tr>
            <td>
                <?php echo e($tanque->id); ?>

            </td>
            <td>
                <?php echo e($tanque->descricao_tanque); ?>

            </td>
            <td>
                <?php echo e($tanque->combustivel->descricao); ?>

            </td>
            <td>
                <?php echo e($tanque->capacidade); ?>

            </td>
            <td>
                <?php echo e($tanque->posicao); ?>

            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.relatorios', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>