<?php $__env->startSection('relatorio'); ?>
<?php echo Charts::scripts(); ?>

    <div class="row">
    <?php $__currentLoopData = $graficos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grafico): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-sm-12 col-md-12 col-lg-12">
            <?php echo $grafico->html(); ?>

        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

<?php $__currentLoopData = $graficos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grafico): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo $grafico->script(); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.relatorios', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>