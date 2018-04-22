<?php $__env->startSection('content'); ?>
    <div class="panel panel-default">
        <?php $__env->startComponent('components.form', [
            'title' => 'Listagem de Veículos', 
            'routeUrl' => route('relatorio_listagem_veiculos'), 
            'formTarget' => '_blank',
            'method' => 'POST',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Gerar Relatório', 'icon' => 'stats'],
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
                            'inputSize' => 3
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
                            'inputSize' => 3,
                            'disabled' => true,
                        ],
                        [
                            'type' => 'select',
                            'field' => 'grupo_id',
                            'label' => 'Grupo',
                            'required' => true,
                            'items' => $grupo_veiculos,
                            'autofocus' => true,
                            'displayField' => 'grupo_veiculo',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 3
                        ],
                        [
                            'type' => 'btn-group',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'radioButtons' => [
                                [
                                    'label' => 'Sim',
                                    'value' => 1
                                ],
                                [
                                    'label' => 'Não',
                                    'value' => 0
                                ],
                                [
                                    'label' => 'Todos',
                                    'value' => -1
                                ],
                            ],
                            'inputSize' => 3,
                            'defaultValue' => -1
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
                        $("#departamento_id")
                            .removeAttr('disabled')
                            .find('option')
                            .remove();

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


            
            $('#cliente_id').on('changed.bs.select', buscarDepartamentos);
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>