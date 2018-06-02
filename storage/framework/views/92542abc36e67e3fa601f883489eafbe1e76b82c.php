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
    $checked = isset($checked) ? $checked : false;
    $indexSelected = isset($indexSelected) ? $indexSelected : old(str_replace('[]', '', $field));
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <strong><?php echo e($title); ?></strong>
    </div>
    <div class="panel-body" style="padding: 0px !important;">
        <div style="margin-bottom: 10px; overflow-y:scroll; height:150px; -webkit-overflow-scrolling: touch;">
            <ul class="list-group">
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $inputValue = false
                    ?>
                    <?php if(isset($indexSelected)): ?>
                    <?php $__currentLoopData = $indexSelected; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($idx == $item->$value): ?>
                            <?php
                            $inputValue = $idx
                            ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <li class="list-group-item">
                    <?php $__env->startComponent('components.input-checkbox', [
                        'checked' => $checked,
                        'dataWidth' => $dataWidth,
                        'dataOn' => $dataOn,
                        'dataOff' => $dataOff,
                        'dataSize' => $dataSize,
                        'dataOnStyle' => $dataOnStyle,
                        'dataOffStyle' => $dataOffStyle,
                        'label' => $item->$label,
                        'field' => $field,
                        'value' => $item->$value,
                        'inputValue' => $inputValue
                    ]); ?> 
                    <?php echo $__env->renderComponent(); ?>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
</div>
