

<?php $__env->startSection('head'); ?>
    <link href="<?php echo e(asset('css/report.css')); ?>" rel="stylesheet" media="all">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
    
    <div class="panel panel-default" style="margin-bottom: 80px">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-2 col-md-2 col-lg-2">
                    <?php if(isset($parametro)): ?>
                        <img src="<?php echo e(asset($parametro->logotipo)); ?>" width="200px">
                    <?php else: ?> 
                        <img src="<?php echo e(asset('images/logo_golden_relatorio.png')); ?>" alt="Golden Service - Controle de Frotas">
                    <?php endif; ?>
                </div>
                <?php if(isset($parametro)): ?>
                <div class="col-sm-10 col-md-10 col-lg-10">    
                    <div class="row">
                        <?php echo e($parametro->cliente->nome_razao); ?> - CNPJ: <?php echo e($parametro->cliente->cpf_cnpj); ?> - IE: <?php echo e($parametro->cliente->rg_ie); ?>

                    </div>
                    <div class="row">
                        <?php echo e($parametro->cliente->endereco); ?>, <?php echo e($parametro->cliente->numero); ?> - <?php echo e($parametro->cliente->bairro); ?>

                    </div>
                    <div class="row">
                        <?php echo e($parametro->cliente->cidade); ?>/<?php echo e($parametro->cliente->uf->uf); ?> - CEP: <?php echo e($parametro->cliente->cep); ?>

                    </div>    
                    <div class="row">
                        <?php if($parametro->cliente->fone1): ?>
                            <div class="report_data report_contacts"><span class="glyphicon glyphicon-earphone"></span> <?php echo e($parametro->cliente->fone1); ?></div>
                        <?php endif; ?>
                        <?php if($parametro->cliente->fone2): ?>
                            <div class="report_data report_contacts"><span class="glyphicon glyphicon-earphone"></span> <?php echo e($parametro->cliente->fone2); ?></div>
                        <?php endif; ?>
                        <?php if($parametro->cliente->email1): ?>
                            <div class="report_data report_contacts"><span class="glyphicon glyphicon-envelope"></span> <?php echo e($parametro->cliente->email1); ?></div>
                        <?php endif; ?>
                        <?php if($parametro->cliente->email2): ?>
                            <div class="report_data report_contacts"><span class="glyphicon glyphicon-envelope"></span> <?php echo e($parametro->cliente->email2); ?></div>
                        <?php endif; ?>
                    </div>    
                </div>
                <?php endif; ?>
                <div class="col col-sm-12 col-md-12 col-lg-12" align="center">
                    <h3><?php echo e($titulo); ?></h3>
                </div>
            </div>
        </div>
        <?php if(isset($parametros) && count($parametros) > 0): ?>
        <div class="panel-sm panel-default">
            <div class="panel-heading">
                <div class="row"><span class="parametro-relatorio" style="margin: 4px">Parâmetros selecionados</span></div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <?php $__currentLoopData = $parametros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parametro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="btn-sm btn-default parametro-relatorio"><?php echo e($parametro); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php echo $__env->yieldContent('relatorio'); ?>
    </div>
    <div class="footer navbar-fixed-bottom">
        <div class="panel panel-default" style="padding: 5px; margin-bottom: 0px" id="print-command-panel">
            <div align="right">
                <span data-toggle="tooltip" data-placement="top" title="Imprimir" data-original-title="Imprimir">
                    <a href="javascript:window.print()" class="btn btn-success" style="margin-right: 10px" id="btn-report-print"><span class="glyphicon glyphicon-print"></span></a>
                </span>
                <span data-toggle="tooltip" data-placement="top" title="Fechar" data-original-title="Fechar">
                    <a href="javascript:window.close()" class="btn btn-danger" style="margin-right: 10px" id="btn-report-close"><span class="glyphicon glyphicon-remove"></span></a>
                </span>
            </div>
        </div>
    </div>
<?php $__env->startComponent('layouts.bottom_scripts'); ?>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>