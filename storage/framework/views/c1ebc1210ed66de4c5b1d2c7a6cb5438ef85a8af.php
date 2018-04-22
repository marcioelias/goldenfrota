<?php
    switch($action) {
        case 'show':
            $btn_style = 'btn-success';
            $btn_icon = 'eye-open';
            $tooltip = 'Mostrar';
            break;
        case 'edit':
            $btn_style = 'btn-warning';
            $btn_icon = 'edit'; 
            $tooltip = 'Editar';
            break;
        case 'destroy':
            $btn_style = 'btn-danger';
            $btn_icon = 'remove';
            $tooltip = 'Remover';
            break;
    }
?>
<?php
    $displayField = isset($displayField) ? $displayField : 'name';
    $keyField = isset($keyField) ? $keyField : 'id';
?>

<?php if($action == 'destroy'): ?>    
    <form id="deleteForm<?php echo e($row->id); ?>" action="<?php echo e(route($model.'.'.$action, ['$model' => $row->$keyField])); ?>" method="POST" style="display: inline">
        <span data-toggle="tooltip" data-placement="top" title="<?php echo e($tooltip); ?>" data-original-title="<?php echo e($tooltip); ?>">
             <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="<?php echo e(__('Remover ').ucFirst($model)); ?>" 
                data-message="Remover <?php echo e(ucFirst($model).': '.$row->$displayField); ?>?">
                <i class="glyphicon glyphicon-trash"></i>
            </button>
        </span>
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
    </form>
<?php else: ?>
    <span data-toggle="tooltip" data-placement="top" title="<?php echo e($tooltip); ?>" data-original-title="<?php echo e($tooltip); ?>">
        <a href="<?php echo e(route($model.'.'.$action, [$model => $row->$keyField])); ?>" class="btn btn-xs <?php echo e($btn_style); ?>"><span class="glyphicon glyphicon-<?php echo e($btn_icon); ?>" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="<?php echo e($tooltip); ?>" data-original-title="<?php echo e($tooltip); ?>"></span></a>
    </span>
<?php endif; ?>
