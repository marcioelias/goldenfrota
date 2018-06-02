<?php $__env->startSection('head'); ?>
    <?php echo $__env->yieldContent('head_includes'); ?>
    <script src="<?php echo e(asset('js/manifest.js')); ?>"></script>
    <script src="<?php echo e(asset('js/vendor.js')); ?>"></script> 
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script src="<?php echo e(asset('js/other.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
    <?php $__env->startComponent('layouts.main_nav'); ?>
    <?php echo $__env->renderComponent(); ?>
    <?php echo $__env->yieldContent('content'); ?>

   
    <?php $__env->startPush('bottom-scripts'); ?>
    <script>
        $('document').ready(function() {
            $('[data-toggle="tooltip"]').tooltip();

            $("#error-alert").fadeTo(8000, 600).slideUp(600, function(){
                $("#error-alert").slideUp(600);
            });
            $("#success-alert").fadeTo(5000, 600).slideUp(600, function(){
                $("#success-alert").slideUp(600);
            });
        });
    </script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->yieldPushContent('bottom-scripts'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>