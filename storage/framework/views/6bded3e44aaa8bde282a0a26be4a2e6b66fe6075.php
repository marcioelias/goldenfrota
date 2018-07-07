<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <?php $__env->startComponent('layouts.main_header'); ?>
    <?php echo $__env->renderComponent(); ?> 
    <?php echo $__env->yieldContent('head'); ?>
</head>
<body>
    <?php echo $__env->yieldContent('body'); ?>
    <?php echo $__env->yieldPushContent('bottom-scripts'); ?>
</body>
</html>