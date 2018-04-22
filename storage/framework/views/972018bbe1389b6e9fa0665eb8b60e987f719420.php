<?php
    $inputSize = isset($inputSize) ? '-'.$inputSize : '-12';
    $disabled = isset($disabled) ? $disabled : false;
    $autofocus = isset($autofocus) ? $autofocus : false;
    $required = isset($required) ? $required : false;
    $css = isset($css) ? $css : '';
    $indexSelected = isset($indexSelected) ? $indexSelected : false;
    $liveSearch = isset($liveSearch) ? $liveSearch : false;
    $defaultNone = isset($defaultNone) ? $defaultNone : false;
?>
<div class="col col-sm col-md<?php echo e($inputSize); ?> col-lg<?php echo e($inputSize); ?> <?php echo e($errors->has($field) ? ' has-error' : ''); ?>">
    <?php if(isset($label)): ?>
        <?php $__env->startComponent('components.label', ['label' => $label, 'field' => $field, 'required' => $required]); ?>
        <?php echo $__env->renderComponent(); ?>
    <?php endif; ?>  
    <select class="form-control selectpicker <?php echo e($css); ?>" <?php echo e($liveSearch ? 'data-live-search=true' : ''); ?> id="<?php echo e($id); ?>" name="<?php echo e($name); ?>" <?php echo e($required ? 'required' : ''); ?>  <?php echo e($autofocus ? 'autofocus' : ''); ?> <?php echo e($disabled ? 'disabled="disabled"' : ''); ?>>
        <?php if(isset($items)): ?>
            <?php if($defaultNone): ?>
                <option  selected value="-1" > Nada Selecionado </option>
            <?php endif; ?>
            <?php if(is_array($items)): ?>
                <?php for($i = 0; $i < count($items); $i++): ?>
                    <option value="<?php echo e($i); ?>" <?php echo e(($i==$indexSelected) ? 'selected=selected' : ''); ?>><?php echo e($items[$i]); ?></option>
                <?php endfor; ?>
            <?php else: ?>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(($item->$keyField == $indexSelected) || ($item->$keyField == old($field))): ?>
                        <option value="<?php echo e($item->$keyField); ?>" selected="selected"><?php echo e($item->$displayField); ?></option>
                    <?php else: ?>
                        <option value="<?php echo e($item->$keyField); ?>"><?php echo e($item->$displayField); ?></option>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endif; ?>
    </select>

    <?php if($errors->has($field)): ?>
        <span class="help-block">
            <strong><?php echo e($errors->first($field)); ?></strong>
        </span>
    <?php endif; ?>
</div>