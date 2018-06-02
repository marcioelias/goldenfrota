<?php
    $inputSize = isset($inputSize) ? '-'.$inputSize : '-12';
    $disabled = isset($disabled) ? $disabled : false;
    $autofocus = isset($autofocus) ? $autofocus : false;
    $required = isset($required) ? $required : false;
    $css = isset($css) ? $css : '';
    $name = isset($name) ? $name : $field;
    $id = isset($id) ? $id : $name;
    $label = isset($label) ? $label : $name;
    $dataOn = isset($dataOn) ? $dataOn : 'Sim';
    $dataOff = isset($dataOff) ? $dataOff : 'Não';
    $dataWidth = isset($dataWidth) ? $dataWidth : 55;
    $dataSize = isset($dataSize) ? $dataSize : 'mini';
    $dataOnStyle = isset($dataOnStyle) ? $dataOnStyle : 'success';
    $dataOffStyle = isset($dataOffStyle) ? $dataOffStyle : 'default';
    $checked = isset($inputValue) ? ($value == $inputValue) : false;
?>

<input type="checkbox" 
    name="<?php echo e($name); ?>"
    value="<?php echo e($value); ?>"
    <?php echo e(($checked) ? 'checked' : ''); ?> 
    data-toggle="toggle" 
    data-width="<?php echo e($dataWidth); ?>" 
    data-on="<?php echo e($dataOn); ?>" 
    data-off="<?php echo e($dataOff); ?>"
    data-size="<?php echo e($dataSize); ?>"
    data-onstyle="<?php echo e($dataOnStyle); ?>"
    data-offstyle="<?php echo e($dataOffStyle); ?>">
    <?php echo e($label); ?>


