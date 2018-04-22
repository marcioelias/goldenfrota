<?php if(Session::has('error')): ?>
    <div class="alert alert-danger alert-dismissible" id="error-alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php echo e(Session::get('error')); ?>

    </div>
<?php endif; ?>