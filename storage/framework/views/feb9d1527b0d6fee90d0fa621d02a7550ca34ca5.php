<?php
    $displayField = isset($displayField) ? $displayField : 'name';
    $keyField = isset($keyField) ? $keyField : 'id';
    //$colorLineCondition = isset($colorLineCondition) ? $colorLineCondition : false;
    if (isset($colorLineCondition)) {
        $lineConditionField = $colorLineCondition['field'];
        $lineConditionValue = $colorLineCondition['value'];
        $lineCondicionClass = $colorLineCondition['class'];
    } else {
        $colorLineCondition = false;
    }
    
?>

<?php if(Session::has('success')): ?>
	<div class="alert alert-success alert-dismissible" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php echo e(Session::get('success')); ?>

    </div>
<?php endif; ?>


<div class="panel panel-default">
    <div class="panel-heading">
       
            <div class="row">
                <div class="col col-sm-12 col-md-12 col-lg-12">
                    <h3><?php echo e(__(isset($tableTitle) ? $tableTitle : 'tableTitle não informado...')); ?></h3>
                </div>
                <form id="searchForm" class="form" method="GET" action="<?php echo e(route($model.'.index')); ?>">
                <div class="col-sm-10 col-md-11 col-lg-11">
                    
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchField" name="searchField" placeholder="<?php echo e(__('Digite aqui para pesquisar...')); ?>" value="<?php echo e(isset($_GET['searchField']) ? $_GET['searchField'] : ''); ?>">
                            <span class="input-group-btn" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('Pesquisar')); ?>" data-original-title="<?php echo e(__('Pesquisar')); ?>">
                                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                            </span>
                        </div>
                    </div>
                    
                </div>
                <div class="col">
                    <?php if (app('laratrust')->can('cadastrar-'. str_replace('_', '-', $model))) : ?>
                    <a href="<?php echo e(route($model.'.create')); ?>" class="btn btn-sm-12 btn-success" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('Novo')); ?>" data-original-title="<?php echo e(__('Novo')); ?>">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    <?php endif; // app('laratrust')->can ?>
                </div>
                <?php if(isset($searchParms)): ?>
                    <?php $__env->startComponent($searchParms); ?>
                    <?php echo $__env->renderComponent(); ?>
                <?php endif; ?>
                </form>
            </div>
         
    </div>
    
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <?php $__currentLoopData = $captions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $caption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(is_array($caption)): ?>
                    <th><?php echo e(__($caption['label'])); ?></th>
                    <?php else: ?>
                    <th><?php echo e(__($caption)); ?></th>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <th class="text-center"><?php echo e(__('Ações')); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($colorLineCondition): ?> 
                <tr <?php echo e(($row->$lineConditionField == $lineConditionValue) ? 'class='.$lineCondicionClass : ''); ?>>
                <?php else: ?>
                <?php if(isset($row->ativo)): ?> 
                <tr <?php echo e((!$row->ativo) ? 'class=danger' : ''); ?>>
                <?php endif; ?>
                <?php endif; ?>
                    <?php $__currentLoopData = $captions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $caption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(is_array($caption)): ?>
                            <?php if($caption['type'] == 'bool'): ?>
                            <td scope="row"><?php echo e(__(($row->$field == '1') ? 'Sim' : 'Não')); ?></td>
                            <?php endif; ?>
                            <?php if($caption['type'] == 'datetime'): ?>
                                <?php if($row->$field): ?> 
                                <td scope="row"><?php echo e(date_format(date_create($row->$field), 'd/m/Y H:i:s')); ?></td>
                                <?php else: ?> 
                                <td scope="row"></td>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if($caption['type'] == 'date'): ?>
                            <td scope="row"><?php echo e(date_format(date_create($row->$field), 'd/m/Y')); ?></td>
                            <?php endif; ?>
                            <?php if($caption['type'] == 'decimal'): ?>
                            <td scope="row"><div align="right"><?php echo e(number_format($row->$field, $caption['decimais'], ',', '.')); ?></div></td>
                            <?php endif; ?>
                        <?php else: ?>
                            <td scope="row">
                                <div <?php echo e(is_numeric($row->$field) ? 'align=right' : ''); ?>>
                                    <?php echo e($row->$field); ?>

                                </div>
                            </td>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <td scope="row" class="text-center">
                        <?php if(is_array($actions)): ?>
                            <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(is_array($action)): ?>
                                    <?php if(isset($action['custom_action'])): ?>
                                        <?php $__env->startComponent($action['custom_action'], ['data' => $row]); ?>
                                        <?php echo $__env->renderComponent(); ?>
                                    <?php else: ?> 
                                        <?php $__env->startComponent('components.action', ['action' => $action['action'], 'model' => $model, 'row' => $row, 'displayField' => $displayField, 'keyField'=> $keyField, 'target' => $action['target']]); ?>
                                        <?php echo $__env->renderComponent(); ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php $__env->startComponent('components.action', ['action' => $action, 'model' => $model, 'row' => $row, 'displayField' => $displayField, 'keyField'=> $keyField]); ?>
                                    <?php echo $__env->renderComponent(); ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
   
    <?php if($rows->links() != ''): ?>
        <div class="panel-footer">
            <div class="text-center">
                <?php echo e($rows->links()); ?>

            </div> 
        </div>
    <?php endif; ?>
</div>

<!-- Modal Dialog -->
<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modal-default">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="row">
            <div class="col-sm-1"><span class="glyphicon glyphicon-alert"></span></div>
            <div class="col"><h4 class="modal-title"><strong></strong></h4></div>
        </div>
      </div>
      <div class="modal-body">
        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="confirm"><?php echo e(__('Remover')); ?></button>
        <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo e(__('Cancelar')); ?></button>        
      </div>
    </div>
  </div>
</div>
<!-- Dialog show event handler -->
<script>
    $('#confirmDelete').on('show.bs.modal', function (e) {
        $message = $(e.relatedTarget).attr('data-message');
        $(this).find('.modal-body p').text($message);
        $title = $(e.relatedTarget).attr('data-title');
        $(this).find('.modal-title').text($title);

        // Pass form reference to modal for submission on yes/ok
        var form = $(e.relatedTarget).closest('form');
        $(this).find('.modal-footer #confirm').data('form', form);
    });

    <!-- Form confirm (yes/ok) handler, submits form -->
    $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
        $(this).data('form').submit();
    });
    $("#success-alert").fadeTo(5000, 600).slideUp(600, function(){
        $("#success-alert").slideUp(600);
    });
</script>