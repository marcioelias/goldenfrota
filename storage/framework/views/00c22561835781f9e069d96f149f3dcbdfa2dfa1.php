<?php $__env->startSection('head'); ?>
    <?php echo $__env->yieldContent('head_includes'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
    <?php $__env->startComponent('layouts.main_nav'); ?>
    <?php echo $__env->renderComponent(); ?>
    <?php echo $__env->yieldContent('content'); ?>
    <?php $__env->startComponent('layouts.bottom_scripts'); ?>
    <?php echo $__env->renderComponent(); ?>
    <?php echo $__env->yieldContent('bottom_includes'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>