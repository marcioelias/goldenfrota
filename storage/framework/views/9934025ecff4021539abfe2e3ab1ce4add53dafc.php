<?php
    $inputSize = isset($inputSize) ? '-'.$inputSize : '-12';
    $items = isset($items) ? $items : false;
    $disabled = isset($disabled) ? $disabled : false;
    $autofocus = isset($autofocus) ? $autofocus : false;
    $required = isset($required) ? $required : false;
    $css = isset($css) ? $css : '';
    $sideBySide = isset($sideBySide) ? $sideBySide : false;
    $dateTimeFormat = isset($dateTimeFormat) ? $dateTimeFormat : false;
    $picker_begin = isset($picker_begin) ? $picker_begin : '';
    $picker_end = isset($picker_end) ? $picker_end : '';
?>


<div class="col col-sm col-md<?php echo e($inputSize); ?> col-lg<?php echo e($inputSize); ?> <?php echo e($errors->has($field) ? ' has-error' : ''); ?>">
    <?php if(isset($label)): ?>
        <?php $__env->startComponent('components.label', ['label' => $label, 'field' => $field, 'required' => $required]); ?>
        <?php echo $__env->renderComponent(); ?>
    <?php endif; ?>  
    
    <div class="input-group date" id="<?php echo e($id); ?>_picker">
        <input type="text" class="form-control <?php echo e($css); ?>" name="<?php echo e($name); ?>" id="<?php echo e($id); ?>" value="<?php echo e(isset($inputValue) ? $inputValue : old($field)); ?>" <?php echo e($required ? 'required' : ''); ?>  <?php echo e($autofocus ? 'autofocus' : ''); ?> <?php echo e($disabled ? 'disabled="disabled"' : ''); ?>>
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>

    <?php if($errors->has($field)): ?>
        <span class="help-block">
            <strong><?php echo e($errors->first($field)); ?></strong>
        </span>
    <?php endif; ?>
</div>
<script type="text/javascript">
    $(function () {
        $('#<?php echo e($id); ?>_picker').datetimepicker({
            <?php echo e($sideBySide ? 'sideBySide: true, ' : ''); ?>

            format : "<?php echo e($dateTimeFormat ? $dateTimeFormat : 'DD/MM/YYYY HH:mm'); ?>",
            <?php echo e(($picker_end == $id) ? 'useCurrent: false' : ''); ?>


        });
        $('#<?php echo e($id); ?>_picker').val('<?php echo e(isset($inputValue) ? $inputValue : old($field)); ?>');
        <?php if($picker_begin == $id): ?> 
            $("#<?php echo e($picker_begin); ?>_picker").on("dp.change", function (e) {
                $('#<?php echo e($picker_end); ?>_picker').data("DateTimePicker").minDate(e.date);
            });
        <?php endif; ?>
        <?php if($picker_end == $id): ?> 
            $("#<?php echo e($picker_end); ?>_picker").on("dp.change", function (e) {
                $('#<?php echo e($picker_begin); ?>_picker').data("DateTimePicker").maxDate(e.date);
            });
        <?php endif; ?>
    });
</script>