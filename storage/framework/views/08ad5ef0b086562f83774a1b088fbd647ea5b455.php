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
        <div class="panel-heading">
                <h3>Minha Conta</h3>
        </div>
        <div class="panel panel-body">
            <div class="col-md-12 col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Dados da Conta
                    </div>
                    <div class="panel-body">
                        <div class="well-sm">
                            <h5><strong>Nome:</strong></h5> <?php echo e($user->name); ?>

                        </div> 
                        <div class="well-sm">
                            <h5><strong>E-mail:</strong></h5> <?php echo e($user->email); ?>

                        </div>
                        <div class="well-sm">
                            <h5><strong>Criado em:</strong></h5> <?php echo e($user->created_at); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senha
                    </div>
                    <div class="panel-body">
                        <a href="<?php echo e(route('user.form.change.password')); ?>" class="btn btn-primary">Alterar minha Senha</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Perfil
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item"><?php echo e($role->display_name); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>