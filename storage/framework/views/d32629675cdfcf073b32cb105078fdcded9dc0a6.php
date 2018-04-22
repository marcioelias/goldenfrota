<?php $__env->startSection('content'); ?>
    <div class="panel panel-default">
        <?php $__env->startComponent('components.form', [
            'title' => 'Alterar Abastecimento', 
            'routeUrl' => route('abastecimento.update', $abastecimento->id), 
            'method' => 'PUT',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Salvar', 'icon' => 'ok'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'remove']
                ]
            ]); ?>
            <?php $__env->startSection('formFields'); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'datetime',
                            'field' => 'data_hora_abastecimento',
                            'label' => 'Data/Hora',
                            'required' => true,
                            'inputSize' => 4,
                            'sideBySide' => true,
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss',
                            'inputValue' => \DateTime::createFromFormat('Y-m-d H:i:s', $abastecimento->data_hora_abastecimento)->format('d/m/Y H:i:s')
                        ],
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
                            'inputSize' => 8,
                            'indexSelected' => isset($cliente->id) ? $cliente->id : null
                        ],
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'veiculo_id',
                            'label' => 'Veículo',
                            'required' => true,
                            'items' => null,
                            'inputSize' => 6,
                            'defaultNone' => true,
                            'displayField' => 'placa',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'indexSelected' => $abastecimento->veiculo_id
                        ],
                        [
                            'type' => 'number',
                            'field' => 'km_veiculo',
                            'label' => 'KM do Veículo',
                            'required' => true,
                            'inputSize' => 3,
                            'inputValue' => $abastecimento->km_veiculo
                        ],
                        [
                            'type' => 'number',
                            'field' => 'media_atual',
                            'label' => 'Média Atual',
                            'required' => true,
                            'inputSize' => 3,
                            'inputValue' => $abastecimento->media_veiculo                            
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.form-group', [   
                    'inputs' => [
                        [
                            'type' => 'number',
                            'field' => 'volume_abastecimento',
                            'label' => 'Quantidade',
                            'required' => true,
                            'inputSize' => 4,
                            'inputValue' => $abastecimento->volume_abastecimento                            
                        ],
                        [
                            'type' => 'number',
                            'field' => 'valor_litro',
                            'label' => 'Valor Unitário',
                            'required' => true,
                            'inputSize' => 4,
                            'inputValue' => $abastecimento->valor_litro                           
                        ],
                        [
                            'type' => 'number',
                            'field' => 'valor_abastecimento',
                            'label' => 'Valor Total',
                            'required' => true,
                            'inputSize' => 4,
                            'readOnly' => true,
                            'inputValue' => $abastecimento->valor_abastecimento                             
                        ],
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'atendente_id',
                            'label' => 'Atendente',
                            'required' => true,
                            'items' => $atendentes,
                            'inputSize' => 12,
                            'displayField' => 'nome_atendente',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'indexSelected' => $abastecimento->atendente_id
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>AUTOMAÇÃO</strong>
                    </div>
                    <div class="panel-body">
                        <?php $__env->startComponent('components.form-group', [
                            'inputs' => [
                                [
                                    'type' => 'select',
                                    'field' => 'bico_id',
                                    'label' => 'Número do Bico',
                                    'required' => true,
                                    'items' => $bicos,
                                    'inputSize' => 4,
                                    'displayField' => 'num_bico',
                                    'keyField' => 'id',
                                    'defaultNone' => true,
                                    'indexSelected' => $abastecimento->bico_id
                                ],
                                [
                                    'type' => 'number',
                                    'field' => 'encerrante_inicial',
                                    'label' => 'Encerrante Inicial',
                                    'required' => true,
                                    'inputSize' => 4,
                                    'inputValue' => $abastecimento->encerrante_inicial                            
                                ],
                                [
                                    'type' => 'number',
                                    'field' => 'encerrante_final',
                                    'label' => 'Encerrante Final',
                                    'required' => true,
                                    'inputSize' => 4,
                                    'inputValue' => $abastecimento->encerrante_final                 
                                ]
                            ]
                        ]); ?>
                        <?php echo $__env->renderComponent(); ?>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>OBSERVAÇÕES</strong>
                    </div>
                    <div class="panel-body">
                        <?php $__env->startComponent('components.form-group', [
                            'inputs' => [
                                [
                                    'type' => 'textarea',
                                    'field' => 'obs_abastecimento',
                                    'label' => false,
                                    'inputValue' => nl2br($abastecimento->obs_abastecimento)
                                ]
                            ]
                        ]); ?>
                        <?php echo $__env->renderComponent(); ?>
                    </div>
                </div>
            <?php $__env->stopSection(); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>
    <script>
        $(document).ready(function() {
            var BuscarVeiculo = function() {
                var cliente = {};

                cliente.id = $('#cliente_id').val();
                cliente._token = $('input[name="_token"]').val();

                $.ajax({
                    url: '<?php echo e(route("veiculos.json")); ?>',
                    type: 'POST',
                    data: cliente,
                    dataType: 'JSON',
                    cache: false,
                    success: function (data) {
                        $("#veiculo_id")
                            .removeAttr('disabled')
                            .find('option')
                            .remove();


                        $.each(data, function (i, item) {
                            $('#veiculo_id').append($('<option>', { 
                                value: item.id,
                                text : item.placa + ' - ' + item.marca_veiculo + ' ' + item.modelo_veiculo
                            }));
                        });
                        
                        <?php if(old('veiculo_id')): ?>
                        $('#veiculo_id').selectpicker('val', <?php echo e(old('veiculo_id')); ?>);
                        <?php else: ?>                        
                        $('#veiculo_id').selectpicker('val', <?php echo e($abastecimento->veiculo_id); ?>);
                        <?php endif; ?>

                        $('.selectpicker').selectpicker('refresh');

                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }

            var CalcularKmMedia = function() {
                var abastecimento = {};

                abastecimento.id = <?php echo e($abastecimento->id); ?>;
                abastecimento.veiculo_id = $('#veiculo_id').val();
                abastecimento._token = $('input[name="_token"]').val();

                //console.log(abastecimento);
                $.ajax({
                    url: '<?php echo e(route("ultimo_abastecimento.json")); ?>',
                    type: 'POST',
                    data: abastecimento,
                    dataType: 'JSON',
                    cache: false,
                    success: function (abastecimento) {
                        //console.log('retorno_json=' + abastecimento);

                        ObterMediaKmVeiculo(abastecimento.km_veiculo);
                    },
                    error: function (abastecimento) {
                        console.log(abastecimento);
                    }
                });
            }

            BuscarVeiculo();
            $('#cliente_id').on('changed.bs.select', BuscarVeiculo);
            $('#cliente_id').on('hide.bs.select', BuscarVeiculo);
            $('#veiculo_id').on('change.bs.select', CalcularKmMedia);
            

            function CalcValorAbastecimento() {
                var volume, valor_unitario = 0;
                volume = parseFloat($('#volume_abastecimento').val().replace(',', '.'));
                valor_unitario = parseFloat($('#valor_litro').val().replace(',', '.'));
                if ((volume > 0) && (valor_unitario > 0)) {
                    $('#valor_abastecimento').val(volume * valor_unitario);
                } else {
                    $('#valor_abastecimento').val(0);
                }
            }

            function ObterMediaKmVeiculo(kmAnterior) {
                //var kmAnterior = BuscarUltimoAbastecimento();
                var kmAtual = $('#km_veiculo').val();
                var qtdAbastecimento = $('#volume_abastecimento').val();
                var mediaCalculada = ((kmAtual - kmAnterior) / qtdAbastecimento).toFixed(3);

                console.log('kmAnterior = ' + kmAnterior);
                console.log('kmAtual = ' + kmAtual);
                console.log('qtdAbastecimento = ' + qtdAbastecimento);
                console.log('kmPercorrido = ' + (kmAtual - kmAnterior));
                console.log('mediaCalculada = ' + mediaCalculada);


                $('#media_atual').val(mediaCalculada);
            }

            $('#volume_abastecimento').keyup(CalcValorAbastecimento);

            $('#valor_litro').keyup(CalcValorAbastecimento);           

            $('#km_veiculo').blur(CalcularKmMedia);

            $('#volume_abastecimento').blur(CalcularKmMedia);
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>