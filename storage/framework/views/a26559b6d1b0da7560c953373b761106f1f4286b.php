<?php
    $inputSize = isset($inputSize) ? '-'.$inputSize : '-12';
    $items = isset($items) ? $items : false;
    $disabled = isset($disabled) ? $disabled : false;
    $autofocus = isset($autofocus) ? $autofocus : false;
    $required = isset($required) ? $required : false;
    $css = isset($css) ? $css : '';
    $numMin = isset($numMin) ? $numMin : '0,00';
    $numMax = isset($numMax) ? $numMax : '999999999,99';
    $numStep = isset($numStep) ? $numStep : 'any';
?>


<div class="col col-sm col-md<?php echo e($inputSize); ?> col-lg<?php echo e($inputSize); ?> <?php echo e($errors->has($field) ? ' has-error' : ''); ?>">
    <?php if(isset($label)): ?>
        <?php $__env->startComponent('components.label', ['label' => $label, 'field' => $field, 'required' => $required]); ?>
        <?php echo $__env->renderComponent(); ?>
    <?php endif; ?>  

    <input type="number" class="form-control <?php echo e($css); ?>" name="<?php echo e($name); ?>" id="<?php echo e($id); ?>" min="<?php echo e($numMin); ?>" max="<?php echo e($numMax); ?>" step="<?php echo e($numStep); ?>" value="<?php echo e(isset($inputValue) ? $inputValue : old($field)); ?>" <?php echo e($required ? 'required' : ''); ?>  <?php echo e($autofocus ? 'autofocus' : ''); ?> <?php echo e($disabled ? 'disabled="disabled"' : ''); ?>>

    <?php if($errors->has($field)): ?>
        <span class="help-block">
            <strong><?php echo e($errors->first($field)); ?></strong>
        </span>
    <?php endif; ?>
</div>