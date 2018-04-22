<?php $__env->startSection('relatorio'); ?>
<?php
    $qtdBico = 0;
    $vlrBico = 0;
    $qtdTotal = 0;
    $vlrTotal = 0;
?>

<?php $__currentLoopData = $bicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bico): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
<?php
    $qtdBico = 0;
    $vlrBico = 0;
?>
<div class="panel-sm">
    <div class="panel-sm">
        <div class="panel-heading report-subtitle-1">
            <h4> Bico: <?php echo e($bico->num_bico); ?> - <?php echo e($bico->descricao_tanque); ?> - <?php echo e($bico->descricao); ?> </h4>
        </div>    
        <div class="panel-body">
            <table class="table table-condensed report-table">
                <thead>
                    <td>Data / Hora</td>
                    <td>Veículo</td>
                    <td align="right">Enc. Inicial</td>
                    <td align="right">Enc. Final</td>
                    <td align="right">Quantidade</td>
                    <td align="right">Valor Unitário</td>
                    <td align="right">Valor Total</td>
                </thead>
                <tbody>
                <?php $__currentLoopData = $bico->abastecimentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $abastecimento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $qtdBico += $abastecimento->volume_abastecimento;
                    $vlrBico += $abastecimento->valor_abastecimento;
                    $qtdTotal += $abastecimento->volume_abastecimento;
                    $vlrTotal += $abastecimento->valor_abastecimento;
                ?>
                    <tr> 
                        <td> <?php echo e(date_format(date_create($abastecimento->data_hora_abastecimento), 'd/m/Y H:i:s')); ?> </td>
                        <td> <?php echo e($abastecimento->placa); ?> </td>
                        <td align="right"> <?php echo e(number_format($abastecimento->encerrante_inicial, 2, ',', '.')); ?> </td>
                        <td align="right"> <?php echo e(number_format($abastecimento->encerrante_final, 2, ',', '.')); ?> </td>
                        <td align="right"> <?php echo e(number_format($abastecimento->volume_abastecimento, 3, ',', '.')); ?> </td>
                        <td align="right"> <?php echo e(number_format($abastecimento->valor_litro, 3, ',', '.')); ?> </td>
                        <td align="right"> <?php echo e(number_format($abastecimento->valor_abastecimento, 3, ',', '.')); ?> </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="success"> 
                        <td colspan=2>Total do Bico</td>
                        <td align="right"></td>
                        <td align="right"></td>
                        <td align="right"><?php echo e(number_format($qtdBico, 3, ',', '.')); ?> </td>
                        <td align="right"> </td>
                        <td align="right"><?php echo e(number_format($vlrBico, 3, ',', '.')); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<table class="table table-condensed report-table">
    <tbody>
        <tr class="default">
            <td><h5>Total Geral</h5></td>
            <td align="right"><h5>Quantidade Abastecida: <?php echo e(number_format($qtdTotal, 3, ',', '.')); ?></h5></td>
            <td align="right"><h5>Valor Abastecido: <?php echo e(number_format($vlrTotal, 3, ',', '.')); ?></h5></td>
        </tr>
    </tbody>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.relatorios', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>