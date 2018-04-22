<?php $__env->startSection('content'); ?>
    <div class="panel panel-default">
        <?php $__env->startComponent('components.form', [
            'title' => 'Alterar Veículo', 
            'routeUrl' => route('veiculo.update', $veiculo->id), 
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
                            'type' => 'select',
                            'field' => 'cliente_id',
                            'label' => 'Cliente',
                            'required' => true,
                            'items' => $clientes,
                            'autofocus' => true,
                            'inputSize' => 7,
                            'displayField' => 'nome_razao',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'indexSelected' => $veiculo->cliente_id
                        ],
                        [
                            'type' => 'select',
                            'field' => 'departamento_id',
                            'label' => 'Departamento',
                            'required' => true,
                            'items' => null,
                            'displayField' => 'departamento',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 4,
                            'indexSelected' => $veiculo->departamento_id
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $veiculo->ativo,
                            'items' => ['Não', 'Sim'],
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'grupo_veiculo_id',
                            'label' => 'Grupo',
                            'required' => true,
                            'items' => $grupoVeiculos,
                            'inputSize' => 6,
                            'displayField' => 'grupo_veiculo',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'indexSelected' => $veiculo->grupo_veiculo_id
                        ],
                        [
                            'type' => 'text',
                            'field' => 'placa',
                            'label' => 'Placa',
                            'required' => true,
                            'inputSize' => 3,
                            'css' => 'uppercase',
                            'inputValue' => $veiculo->placa
                        ],
                        [
                            'type' => 'text',
                            'field' => 'tag',
                            'label' => 'TAG',
                            'inputSize' => 3,
                            'inputValue' => $veiculo->tag
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'marca_veiculo_id',
                            'label' => 'Marca',
                            'required' => true,
                            'items' => $marcaVeiculos,
                            'inputSize' => 5,
                            'displayField' => 'marca_veiculo',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'indexSelected' => $marcaVeiculo
                        ],
                        [
                            'type' => 'select',
                            'field' => 'modelo_veiculo_id',
                            'label' => 'Modelo',
                            'required' => true,
                            'items' => $modeloVeiculos,
                            'inputSize' => 5,
                            'displayField' => 'modelo_veiculo',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'indexSelected' => $veiculo->modelo_veiculo_id
                        ],
                        [
                            'type' => 'text',
                            'field' => 'ano',
                            'label' => 'Ano',
                            'inputSize' => 2,
                            'inputValue' => $veiculo->ano
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'renavam',
                            'label' => 'Renavam',
                            'inputSize' => 3,
                            'inputValue' => $veiculo->renavam
                        ],
                        [
                            'type' => 'text',
                            'field' => 'chassi',
                            'label' => 'Chassi',
                            'inputSize' => 3,
                            'inputValue' => $veiculo->chassi
                        ],
                        [
                            'type' => 'text',
                            'field' => 'hodometro',
                            'label' => 'Km',
                            'inputSize' => 3,
                            'inputValue' => $veiculo->hodometro
                        ],
                        [
                            'type' => 'text',
                            'field' => 'media_minima',
                            'label' => 'Média Mínima',
                            'inputSize' => 3,
                            'inputValue' => $veiculo->media_minima
                        ],
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
            <?php $__env->stopSection(); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>
    <script>
        $(document).ready(function() {
            $('#placa').mask('AAA-9999', {placeholder: '___-____'});
            
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
                        $("#departamento_id")
                            .removeAttr('disabled')
                            .find('option')
                            .remove();

                        $('#departamento_id').append('<option disabled selected value style="display:none"> Nada Selecionado </option>');

                        $.each(data, function (i, item) {
                            $('#departamento_id').append($('<option>', { 
                                value: item.id,
                                text : item.departamento 
                            }));
                        });
                        
                        <?php if(old('departamento_id')): ?>
                        $('#departamento_id').selectpicker('val', <?php echo e(old('departamento_id')); ?>);
                        <?php else: ?>
                        $('#departamento_id').selectpicker('val', <?php echo e($veiculo->departamento_id); ?>);
                        <?php endif; ?>

                        $('.selectpicker').selectpicker('refresh');
                    }
                });
            }

            var buscarModeloVeiculos = function() {
                var marca = {};

                marca.id = $('#marca_veiculo_id').val();
                marca._token = $('input[name="_token"]').val();

                console.log(marca);
                $.ajax({
                    url: '<?php echo e(route("modelo_veiculos.json")); ?>',
                    type: 'POST',
                    data: marca,
                    dataType: 'JSON',
                    cache: false,
                    success: function (data) {
                        console.log(data);
                        $("#modelo_veiculo_id")
                            .removeAttr('disabled')
                            .find('option')
                            .remove();


                        $.each(data, function (i, item) {
                            $('#modelo_veiculo_id').append($('<option>', { 
                                value: item.id,
                                text : item.modelo_veiculo 
                            }));
                        });

                        <?php if(old('modelo_veiculo_id')): ?>
                        $('#modelo_veiculo_id').selectpicker('val', <?php echo e(old('modelo_veiculo_id')); ?>);
                        <?php else: ?>
                        $('#modelo_veiculo_id').selectpicker('val', <?php echo e($veiculo->modelo_veiculo_id); ?>);
                        <?php endif; ?>

                        $('.selectpicker').selectpicker('refresh');
                    }
                });
            }

            buscarDepartamentos();
            buscarModeloVeiculos();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>