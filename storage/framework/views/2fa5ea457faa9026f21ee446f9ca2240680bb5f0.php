<?php
    $abast_local = isset($_GET['abast_local']) ? $_GET['abast_local'] : -1;
    $data_inicial = isset($_GET['data_inicial']) ? $_GET['data_inicial'] : null;
    $data_final = isset($_GET['data_final']) ? $_GET['data_final'] : null;
?>


<?php $__env->startSection('content'); ?>
    <div class="panel panel-default">
        <?php $__env->startComponent('components.form', [
            'title' => 'Relatório de Abastecimentos - Bicos', 
            'routeUrl' => route('param_relatorio_abastecimentos_bico'), 
            'formTarget' => '_blank',
            'method' => 'POST',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Gerar Relatório', 'icon' => 'stats'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'remove']
                ]
            ]); ?>
            <?php $__env->startSection('formFields'); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'datetime',
                            'field' => 'data_inicial',
                            'label' => 'Data Inicial',
                            'inputSize' => 3,
                            'dateTimeFormat' => 'DD/MM/YYYY',
                            'picker_begin' => 'data_inicial',
                            'picker_end' => 'data_final',
                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_final',
                            'label' => 'Data Final',
                            'inputSize' => 3,
                            'dateTimeFormat' => 'DD/MM/YYYY',
                            'picker_begin' => 'data_inicial',
                            'picker_end' => 'data_final',
                        ],
                        [
                            'type' => 'select',
                            'field' => 'bico_id',
                            'label' => 'Bico',
                            'required' => true,
                            'items' => $bicos,
                            'autofocus' => true,
                            'displayField' => 'num_bico',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 6
                        ]
                    ]
                ]); ?>  
                <?php echo $__env->renderComponent(); ?> 
            <?php $__env->stopSection(); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>
    <script>
        $(document).ready(function() {
            var buscarDepartamentos = function() {
                var departamento = {};

                departamento.id = $('#cliente_id').val();
                departamento._token = $('input[name="_token"]').val();

                console.log(departamento);
                $.ajax({
                    url: '<?php echo e(route("departamentos.json")); ?>',
                    type: 'POST',
                    data: departamento,
                    dataType: 'JSON',
                    cache: false,
                    success: function (data) {
                        console.log(data);
                        if (data.length > 0) {
                            $("#departamento_id")
                                .removeAttr('disabled')
                                .find('option')
                                .remove();
                        } else {
                            if ($('#cliente_id').val() == -1) {
                                $("#departamento_id").attr('disabled', 'disabled');
                            }
                        }

                        $('#departamento_id').append($('<option>', { 
                                value: -1,
                                text : 'NADA SELECIONADO'
                        }));
                        $.each(data, function (i, item) {
                            $('#departamento_id').append($('<option>', { 
                                value: item.id,
                                text : item.departamento 
                            }));
                        });
                        
                        <?php if(old('departamento_id')): ?>
                        $('#departamento_id').selectpicker('val', <?php echo e(old('departamento_id')); ?>);
                        <?php endif; ?>

                        $('.selectpicker').selectpicker('refresh');
                    }
                });                
            }

            var buscarVeiculos = function() {
                var cliente = {};

                cliente.id = $('#cliente_id').val();
                cliente._token = $('input[name="_token"]').val();

                //console.log(cliente);
                $.ajax({
                    url: '<?php echo e(route("veiculos.json")); ?>',
                    type: 'POST',
                    data: cliente,
                    dataType: 'JSON',
                    cache: false,
                    success: function (data) {
                        //console.log(data);
                        $("#veiculo_id")
                            .removeAttr('disabled')
                            .find('option')
                            .remove();

                        $('#veiculo_id').append($('<option>', { 
                                value: -1,
                                text : 'NADA SELECIONADO'
                        }));
                        $.each(data, function (i, item) {
                            $('#veiculo_id').append($('<option>', { 
                                value: item.id,
                                text : item.placa + ' - ' + item.marca_veiculo + ' ' + item.modelo_veiculo
                            }));
                        });
                        
                        <?php if(old('modelo_veiculo_id')): ?>
                        $('#modelo_veiculo_id').selectpicker('val', <?php echo e(old('modelo_veiculo_id')); ?>);
                        <?php endif; ?>

                        $('.selectpicker').selectpicker('refresh');
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }

            var buscarVeiculosDepartamento = function() {
                var departamento = {};

                departamento.id = $('#departamento_id').val();
                departamento.cliente_id = $('#cliente_id').val();
                departamento._token = $('input[name="_token"]').val();

                console.log(departamento);
                $.ajax({
                    url: '<?php echo e(route("veiculos_departamento.json")); ?>',
                    type: 'POST',
                    data: departamento,
                    dataType: 'JSON',
                    cache: false,
                    success: function (data) {
                        console.log(data);
                        $("#veiculo_id")
                            .removeAttr('disabled')
                            .find('option')
                            .remove();

                        $('#veiculo_id').append($('<option>', { 
                                value: -1,
                                text : 'NADA SELECIONADO'
                        }));
                        $.each(data, function (i, item) {
                            $('#veiculo_id').append($('<option>', { 
                                value: item.id,
                                text : item.placa + ' - ' + item.marca_veiculo + ' ' + item.modelo_veiculo
                            }));
                        });
                        
                        <?php if(old('modelo_veiculo_id')): ?>
                        $('#modelo_veiculo_id').selectpicker('val', <?php echo e(old('modelo_veiculo_id')); ?>);
                        <?php endif; ?>

                        $('.selectpicker').selectpicker('refresh');
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }

            var buscarPorCliente = function() {
                buscarDepartamentos();
                buscarVeiculos();
            }

            $('#cliente_id').on('changed.bs.select', buscarPorCliente);
            $('#departamento_id').on('changed.bs.select', buscarVeiculosDepartamento);
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>