

<?php $__env->startSection('content'); ?>
    <div class="panel panel-default">
        <?php $__env->startComponent('components.form', [
            'title' => 'Alterar Perfil de Acesso', 
            'routeUrl' => route('role.update', $role->id), 
            'method' => 'PUT',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Save', 'icon' => 'ok'],
                ['type' => 'button', 'label' => 'Cancel', 'icon' => 'remove']
                ]
            ]); ?>
            <?php $__env->startSection('formFields'); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'name',
                            'label' => 'Identificação',
                            'required' => true,
                            'inputSize' => 6,
                            'inputValue' => $role->name
                        ],
                        [
                            'type' => 'text',
                            'field' => 'display_name',
                            'label' => 'Perfil',
                            'required' => true,
                            'inputSize' => 6,
                            'inputValue' => $role->display_name
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'textarea',
                            'field' => 'description',
                            'label' => 'Descrição',
                            'inputValue' => $role->description
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Permissões Associadas <button type="button" id="btnCheckAll" class="btn btn-default btn-xs btn-link">Marcar todos</button><button type="button" id="btnUnCheckAll" class="btn btn-default btn-xs btn-link hidden">Desmarcar todos</button>
                    </div>
                    <div class="panel-body">
                        <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-sm-1 col-md-3 col-lg-3">
                                <input type="checkbox" class="permission_checkbox" name="permissions[]" value="<?php echo e($permission->id); ?>" <?php echo e(in_array($permission->id, $assigned_permissions) ? 'checked' : ''); ?> >
                                <?php echo e($permission->display_name); ?>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php $__env->stopSection(); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>
    <script>
        $('document').ready(function() {
            var doCheckAll = function checkPermissions() {
                $('.permission_checkbox').prop('checked', true);
                $('#btnCheckAll').toggleClass('hidden');
                $('#btnUnCheckAll').toggleClass('hidden');
            }

            var doUnCheckAll = function unCheckPermissions() {
                $('.permission_checkbox').prop('checked', false);
                $('#btnCheckAll').toggleClass('hidden');
                $('#btnUnCheckAll').toggleClass('hidden');
            }

            $('#btnCheckAll').click(doCheckAll);
            $('#btnUnCheckAll').click(doUnCheckAll);
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>