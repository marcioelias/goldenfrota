<?php
    $btnAlign = isset($btnAlign) ? $btnAlign : 'Right';
    $btnColor = ['submit' => 'success', 'reset' => 'danger', 'button' => 'danger'];
    $fileUpload = (isset($fileUpload) && $fileUpload) ? 'enctype=multipart/form-data' : '';
?>

<?php if($title != ''): ?>
    <div class="panel-heading"><h3><?php echo e(__($title)); ?></h3></div>
<?php endif; ?>
<div class="panel-body">
    
    <form class="form" <?php echo e(isset($formTarget) ? 'target='.$formTarget : ''); ?> role="form" method="POST" action="<?php echo e($routeUrl); ?>" <?php echo e($fileUpload); ?>>
        <?php echo e(csrf_field()); ?>


        <?php if(isset($method)): ?>
            <?php if($method != 'POST'): ?>
                <input name="_method" type="hidden" value="<?php echo e($method); ?>">
            <?php endif; ?>
        <?php endif; ?>

        <?php echo $__env->yieldContent('formFields'); ?>

        

        <div class="form-group">
            <div class="<?php echo e(($btnAlign == 'Right') ? 'pull-right' : ''); ?>">
                <?php if(is_array($formButtons)): ?> 
                    <?php $__currentLoopData = $formButtons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formButton): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(($formButton['type'] == 'submit') || ($formButton['type'] == 'reset')): ?>
                            <button type="<?php echo e($formButton['type']); ?>" class="btn btn-<?php echo e($btnColor[$formButton['type']]); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(__($formButton['label'])); ?>" data-original-title="<?php echo e(__($formButton['label'])); ?>">
                                <?php if(isset($formButton['icon'])): ?>
                                    <span class="glyphicon glyphicon-<?php echo e($formButton['icon']); ?>"></span>
                                <?php else: ?>
                                    <?php echo e(__($formButton['label'])); ?>

                                <?php endif; ?>
                            </button>
                        <?php else: ?>
                            <a href="<?php echo e(url()->previous()); ?>" class="btn btn-<?php echo e($btnColor[$formButton['type']]); ?>"  data-toggle="tooltip" data-placement="top" title="<?php echo e(__($formButton['label'])); ?>" data-original-title="<?php echo e(__($formButton['label'])); ?>">
                                <?php if(isset($formButton['icon'])): ?>
                                    <span class="glyphicon glyphicon-<?php echo e($formButton['icon']); ?>"></span>
                                <?php else: ?>
                                    <?php echo e(__($formButton['label'])); ?>

                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <button type="submit" class="btn btn-primary"  data-toggle="tooltip" data-placement="top" title="<?php echo e(__($formButton['label'])); ?>" data-original-title="<?php echo e(__($formButton['label'])); ?>">
                        <?php if(isset($formButton['icon'])): ?>
                            <span class="glyphicon glyphicon-<?php echo e($formButton['icon']); ?>"></span>
                        <?php else: ?>
                            <?php echo e(__($formButton['label'])); ?>

                        <?php endif; ?>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>