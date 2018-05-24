

<?php $__env->startSection('content'); ?>
    <div class="panel panel-default">
        <?php $__env->startComponent('components.form', [
            'title' => 'Novo Abastecimento', 
            'routeUrl' => route('abastecimento.store'), 
            'method' => 'POST',
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
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss',
                            'sideBySide' => true
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
                            'inputSize' => 8
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
                            'disabled' => true,
                            'inputSize' => 4,
                            'displayField' => 'placa',
                            'liveSearch' => true,
                            'keyField' => 'id'
                        ],
                        [
                            'type' => 'text',
                            'field' => 'km_veiculo',
                            'label' => 'KM do Veículo',
                            'required' => true,
                            'inputSize' => 2                            
                        ],
                        [
                            'type' => 'number',
                            'field' => 'volume_abastecimento',
                            'label' => 'Quantidade',
                            'required' => true,
                            'inputSize' => 2                            
                        ],
                        [
                            'type' => 'number',
                            'field' => 'valor_litro',
                            'label' => 'Valor Unitário',
                            'required' => true,
                            'inputSize' => 2                            
                        ],
                        [
                            'type' => 'number',
                            'field' => 'valor_abastecimento',
                            'label' => 'Valor Total',
                            'required' => true,
                            'inputSize' => 2,
                            'readOnly' => true                            
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
            <?php $__env->stopSection(); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>
    <script>
        $(document).ready(function() {
            //$('#valor_litro').mask('#.000', );
           
            $('#km_veiculo').mask('#');

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

            $('#volume_abastecimento').keyup(CalcValorAbastecimento);

            $('#valor_litro').keyup(CalcValorAbastecimento);

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

            $('#cliente_id').on('changed.bs.select', buscarVeiculos);

            if ($('#cliente_id').val()) {
                buscarVeiculos();
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>