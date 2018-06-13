

<?php $__env->startSection('content'); ?>
    <div class="panel panel-default">
        <?php $__env->startComponent('components.form', [
            'title' => 'Nova Entrada de Combustível', 
            'routeUrl' => route('tanque_movimentacao.store'), 
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
                            'field' => 'data_movimentacao',
                            'label' => 'Data',
                            'required' => true,
                            'inputSize' => 4,
                            'dateTimeFormat' => 'DD/MM/YYYY',
                            //'inputValue' => isset($tanque_movimentacao->data_movimentacao) ? $tanque_movimentacao->data_movimentacao : null,
                        ],
                        [
                            'type' => 'text',
                            'field' => 'documento',
                            'label' => 'Documento',
                            'inputSize' => 4,
                            //'inputValue' => isset($tanque_movimentacao->documento) ? $tanque_movimentacao->documento : null,
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'combustivel_id',
                            'label' => 'Combustível',
                            'items' => $combustiveis,
                            'inputSize' => 4,
                            'displayField' => 'descricao',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'defaultNone' => true
                        ],
                        [
                            'type' => 'select',
                            'field' => 'tanque_id',
                            'label' => 'Tanque',
                            'items' => null,
                            'inputSize' => 4,
                            'displayField' => 'descricao_tanque',
                            'keyField' => 'id',
                            'liveSearch' => true,
                        ],
                        [
                            'type' => 'text',
                            'field' => 'quantidade_combustivel',
                            'label' => 'Quantidade',
                            'inputSize' => 4
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
            <?php $__env->stopSection(); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>
    <script>
        $(document).ready(function() {
            var BuscarTanque = function() {
                var combustivel = {};

                combustivel.id = $('#combustivel_id').val();
                combustivel._token = $('input[name="_token"]').val();

                $.ajax({
                    url: '<?php echo e(route("tanques.json")); ?>',
                    type: 'POST',
                    data: combustivel,
                    dataType: 'JSON',
                    cache: false,
                    success: function (data) {
                        console.log(data);
                        $("#tanque_id")
                            .removeAttr('disabled')
                            .find('option')
                            .remove();


                        $.each(data, function (i, item) {
                            $('#tanque_id').append($('<option>', { 
                                value: item.id,
                                text : item.descricao_tanque 
                            }));
                        });
                        
                        
                        $('.selectpicker').selectpicker('refresh');
                    }
                });
            }

            BuscarTanque();
            $('#combustivel_id').on('changed.bs.select', BuscarTanque);
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>