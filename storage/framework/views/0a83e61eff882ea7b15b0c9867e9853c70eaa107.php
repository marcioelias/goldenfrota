<?php
    $inputSize = isset($inputSize) ? '-'.$inputSize : '-12';
    $items = isset($items) ? $items : false;
    $disabled = isset($disabled) ? $disabled : false;
    $autofocus = isset($autofocus) ? $autofocus : false;
    $required = isset($required) ? $required : false;
    $css = isset($css) ? $css : '';
    $rows = isset($rows) ? $rows : 5;
    $name = isset($name) ? $name : $field;
    $id = isset($id) ? $id : $name;
?>


<div class="col col-sm col-md<?php echo e($inputSize); ?> col-lg<?php echo e($inputSize); ?> <?php echo e($errors->has($field) ? ' has-error' : ''); ?>">
    <?php if(isset($label)): ?>
        <?php $__env->startComponent('components.label', ['label' => $label, 'field' => $field, 'required' => $required]); ?>
        <?php echo $__env->renderComponent(); ?>
    <?php endif; ?>
    <textarea rows="<?php echo e($rows); ?>" class="form-control <?php echo e($css); ?>" name="<?php echo e($name); ?>" id="<?php echo e($id); ?>" <?php echo e($required ? 'required' : ''); ?>  <?php echo e($autofocus ? 'autofocus' : ''); ?> <?php echo e($disabled ? 'disabled="disabled"' : ''); ?>><?php echo e(isset($inputValue) ? $inputValue : old($field)); ?></textarea>  

    <?php if($errors->has($field)): ?>
        <span class="help-block">
            <strong><?php echo e($errors->first($field)); ?></strong>
        </span>
    <?php endif; ?>
</div>