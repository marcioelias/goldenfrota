<?php $__env->startSection('relatorio'); ?>
<table class="table table-condensed report-table">
    <thead>
        <tr class="info">
            <td>
                Id
            </td>
            <td>
                Produto
            </td>
            <td>
                Qtd em Estoque
            </td>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $produtos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
        <tr>
            <td>
                <?php echo e($produto->id); ?>

            </td>
            <td>
                <?php echo e($produto->produto_descricao); ?>

            </td>
            <td>
                <?php echo e($produto->posicao); ?>

            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.relatorios', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>