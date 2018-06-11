

<?php $__env->startSection('relatorio'); ?>
<table class="table table-condensed table-bordered report-table">
    <thead>
        <tr class="info">
            <td>
                Id
            </td>
            <td>
                Produto
            </td>
            <td>
                Qtd Em Estoque
            </td>
            <td>
                Qtd Contada
            </td>
            <td>
                Ajuste
            </td>
            <td>
                Ajustado
            </td>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $inventario->inventario_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventario_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
        <tr>
            <td>
                <?php echo e($inventario_item->produto->id); ?>

            </td>
            <td>
                <?php echo e($inventario_item->produto->produto_descricao); ?>

            </td>
            <td>
                <?php echo e($inventario_item->qtd_estoque); ?>

            </td>
            <td>
                <?php echo e(($inventario_item->qtd_contada > 0) ? $inventario_item->qtd_contada : ''); ?>

            </td>
            <td>
                <?php echo e($inventario_item->qtd_ajuste); ?>

            </td>
            <td>
                <?php echo e(($inventario_item->ajustado) ? 'Sim' : 'Não'); ?>

            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.relatorios', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>