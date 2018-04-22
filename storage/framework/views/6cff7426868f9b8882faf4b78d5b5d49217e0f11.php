<?php $__env->startSection('content'); ?>
    <?php if(Session::has('success')): ?>
        <div class="alert alert-success alert-dismissible" id="success-alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?php echo e(Session::get('success')); ?>

        </div>
    <?php endif; ?>
    <div class="panel panel-default">
        <?php $__env->startComponent('components.form', [
            'title' => 'Parametrização', 
            'routeUrl' => route('parametro.update', $parametro->id), 
            'method' => 'PUT',
            'fileUpload' => true,
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Salvar', 'icon' => 'ok'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'remove']
                ]
            ]); ?>
            <?php $__env->startSection('formFields'); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'cliente_id',
                            'label' => 'Cliente',
                            'required' => true,
                            'items' => $clientes,
                            'autofocus' => true,
                            'displayField' => 'nome_razao',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 12,
                            'indexSelected' => $parametro->cliente_id
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'file',
                            'field' => 'logotipo',
                            'label' => 'Logotipo',
                            'required' => true,
                            'inputValue' => $parametro->logotipo
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php if($parametro->logotipo): ?>
                <div class="panel">
                    <div>
                        <img src="<?php echo e(asset($parametro->logotipo)); ?>" width="200px">
                    </div>
                </div>
                <?php endif; ?>
            <?php $__env->stopSection(); ?> 
        <?php echo $__env->renderComponent(); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>