<?php $__env->startSection('relatorio'); ?>
<?php
    $clienteVolume = 0;
    $clienteDistancia = 0;
    $departamentoVolume = 0;
    $departamentoDistancia = 0;
    $distanciaTotal = 0;
    $volumeTotal = 0;
?>

<?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
<?php
    $clienteVolume = 0;
    $clienteDistancia = 0;
?>
<div class="panel-sm">
    <div class="panel-sm">
        <div class="panel-heading report-subtitle-1">
            <h4> Cliente: <?php echo e($cliente->nome_razao); ?> </h4>
        </div>    
        <div class="panel-body">
            <?php $__currentLoopData = $cliente->departamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $departamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $departamentoVolume = 0;
                $departamentoDistancia = 0;     
            ?>
            <div class="panel-sm">
                <div class="panel-heading report-subtitle-1">
                    <h5>Departamento: <?php echo e($departamento->departamento); ?></h5>
                </div>
                <div class="panel-body">
                    <table class="table table-condensed report-table">
                        <thead>
                            <td>Veículo</td>
                            <td align="right">KM Inicial</td>
                            <td align="right">KM Final</td>
                            <td align="right">Distância Percorrida</td>
                            <td align="right">Consumo Médio/KM</td>
                            <td align="right">Consumo Total</td>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $departamento->abastecimentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $abastecimento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $clienteVolume += $abastecimento->consumo;
                                $clienteDistancia += $abastecimento->km_final - $abastecimento->km_inicial;
                                $departamentoVolume += $abastecimento->consumo; 
                                $departamentoDistancia += $abastecimento->km_final - $abastecimento->km_inicial;  
                                $distanciaTotal += $abastecimento->km_final - $abastecimento->km_inicial;  
                                $volumeTotal += $abastecimento->consumo;
                            ?>
                            <tr> 
                                <td> <?php echo e($abastecimento->placa); ?> </td>
                                <td align="right"> <?php echo e(number_format($abastecimento->km_inicial, 1, ',', '.')); ?> </td>
                                <td align="right"> <?php echo e(number_format($abastecimento->km_final, 1, ',', '.')); ?> </td>
                                <td align="right"> <?php echo e(number_format($abastecimento->km_final - $abastecimento->km_inicial, 1, ',', '.')); ?> </td>
                                <td align="right"> <?php echo e(number_format($abastecimento->media, 2, ',', '.')); ?> </td>
                                <td align="right"> <?php echo e(number_format($abastecimento->consumo, 2, ',', '.')); ?> </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr class="success"> 
                                <td colspan=2>Total do Departamento</td>
                                <td align="right"></td>
                                <td align="right"><?php echo e(number_format($departamentoDistancia, 1, ',', '.')); ?> </td>
                                <td align="right"> </td>
                                <td align="right"><?php echo e(number_format($departamentoVolume, 3, ',', '.')); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<table class="table table-condensed report-table">
    <tbody>
        <tr class="default">
            <td><h5>Total Geral</h5></td>
            <td align="right"><h5>Distância Percorrida: <?php echo e(number_format($distanciaTotal, 1, ',', '.')); ?></h5></td>
            <td align="right"><h5>Consumo Total: <?php echo e(number_format($volumeTotal, 3, ',', '.')); ?></h5></td>
        </tr>
    </tbody>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.relatorios', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>