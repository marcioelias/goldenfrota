<label for="<?php echo e($field); ?>" class="control-label">
    <?php if(isset($required)): ?>
        <?php if($required): ?>
        
        <?php endif; ?>
    <?php endif; ?>
    <?php echo e(__($label)); ?>

</label>