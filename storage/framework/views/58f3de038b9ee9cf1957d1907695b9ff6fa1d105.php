<?php $__env->startSection('content'); ?>
<?php if(Session::has('success')): ?>
    <div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php echo e(Session::get('success')); ?>

    </div>
<?php endif; ?>

<script>
    $('document').ready(function() {
        $("#success-alert").fadeTo(8000, 600).slideUp(600, function(){
            $("#success-alert").slideUp(600);
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>