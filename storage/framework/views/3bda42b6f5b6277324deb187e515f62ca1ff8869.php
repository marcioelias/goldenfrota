<?php
    $inputSize = isset($inputSize) ? '-'.$inputSize : '-12';
    $items = isset($items) ? $items : false;
    $disabled = isset($disabled) ? $disabled : false;
    $autofocus = isset($autofocus) ? $autofocus : false;
    $required = isset($required) ? $required : false;
?>
<div class="col col-sm col-md<?php echo e($inputSize); ?> col-lg<?php echo e($inputSize); ?> <?php echo e($errors->has($field) ? ' has-error' : ''); ?>">
    <?php if(isset($label)): ?>
        <?php $__env->startComponent('components.label', ['label' => $label, 'field' => $field, 'required' => $required]); ?>
        <?php echo $__env->renderComponent(); ?>
    <?php endif; ?>  

    <input type="password" class="form-control" name="<?php echo e($name); ?>" id="<?php echo e($id); ?>" value="" <?php echo e($required ? 'required' : ''); ?>  <?php echo e($autofocus ? 'autofocus' : ''); ?> <?php echo e($disabled ? 'disabled="disabled"' : ''); ?>>

    <?php if($errors->has($field)): ?>
        <span class="help-block">
            <strong><?php echo e(__($errors->first($field))); ?></strong>
        </span>
    <?php endif; ?>
</div>