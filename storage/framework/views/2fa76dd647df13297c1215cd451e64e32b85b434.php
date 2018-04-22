<?php $__env->startSection('relatorio'); ?>
<table class="table table-condensed report-table">
    <thead>
        <tr class="info">
            <td>
                Id
            </td>
            <td>
                Nome/Razão
            </td>
            <td>
                CPF/CNPJ
            </td>
            <td>
                RG/IE
            </td>
            <td>
                Fone [1]
            </td>
            <td>
                Fone [2]
            </td>
            <td>
                Endereço
            </td>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
        <tr>
            <td>
                <?php echo e($cliente->id); ?>

            </td>
            <td>
                <?php echo e($cliente->nome_razao); ?>

            </td>
            <td>
                <?php echo e($cliente->cpf_cnpj); ?>

            </td>
            <td>
                <?php echo e($cliente->rg_ie); ?>

            </td>
            <td>
                <?php echo e($cliente->fone1); ?>

            </td>
            <td>
                <?php echo e($cliente->fone2); ?>

            </td>
            <td>
                <?php echo e($cliente->endereco.', '.$cliente->numero.' - '.$cliente->bairro.' - '.$cliente->cidade.'/'.$cliente->uf->uf); ?>

            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.relatorios', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>