

<?php $__env->startSection('content'); ?>
    <div class="panel panel-default">
        <?php $__env->startComponent('components.form', [
            'title' => 'Novo Fornecedor', 
            'routeUrl' => route('fornecedor.store'), 
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
                            'type' => 'select',
                            'field' => 'tipo_pessoa_id',
                            'label' => 'Tipo Pessoa',
                            'required' => true,
                            'autofocus' => true,
                            'items' => $tipoPessoas,
                            'inputSize' => 2,
                            'displayField' => 'tipo_pessoa',
                            'keyField' => 'id',
                            'liveSearch' => true
                        ],
                        [
                            'type' => 'text',
                            'field' => 'nome_razao',
                            'label' => 'Nome/Razão Sozial',
                            'required' => true,
                            'inputSize' => 10
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'apelido_fantasia',
                            'label' => 'Nome Fantasia',
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'cpf_cnpj',
                            'label' => 'CPF/CNPJ',
                            'required' => true,
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'text',
                            'field' => 'rg_ie',
                            'label' => 'RG/IE',
                            'required' => true,
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'text',
                            'field' => 'im',
                            'label' => 'Insc. Mun.',
                            'required' => true,
                            'inputSize' => 4
                        ]
                    ]
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>CONTATOS</strong>
                    </div>
                    <div class="panel-body">
                        <?php $__env->startComponent('components.form-group', [
                            'inputs' => [
                                [
                                    'type' => 'text',
                                    'field' => 'fone',
                                    'label' => 'Fone',
                                    'required' => true,
                                    'inputSize' => 6,
                                    'css' => 'mask_phone'
                                ],
                                [
                                    'type' => 'text',
                                    'field' => 'email',
                                    'label' => 'E-mail',
                                    'inputSize' => 6
                                ],
                            ]
                        ]); ?>
                        <?php echo $__env->renderComponent(); ?>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>ENDEREÇO</strong>
                    </div>
                    <div class="panel-body">
                        <?php $__env->startComponent('components.form-group', [
                            'inputs' => [
                                [
                                    'type' => 'text',
                                    'field' => 'endereco',
                                    'label' => 'Endereço',
                                    'required' => true,
                                    'inputSize' => 11
                                ],
                                [
                                    'type' => 'text',
                                    'field' => 'numero',
                                    'label' => 'Número',
                                    'inputSize' => 1
                                ],
                            ]
                        ]); ?>
                        <?php echo $__env->renderComponent(); ?>
                        <?php $__env->startComponent('components.form-group', [
                            'inputs' => [
                                [
                                    'type' => 'text',
                                    'field' => 'bairro',
                                    'label' => 'Bairro',
                                    'inputSize' => 4
                                ],
                                [
                                    'type' => 'text',
                                    'field' => 'cidade',
                                    'label' => 'Cidade',
                                    'inputSize' => 4
                                ],
                                [
                                    'type' => 'text',
                                    'field' => 'cep',
                                    'label' => 'Cep',
                                    'inputSize' => 2
                                ],
                                [
                                    'type' => 'select',
                                    'field' => 'uf_id',
                                    'label' => 'UF',
                                    'required' => true,
                                    'items' => $ufs,
                                    'inputSize' => 2,
                                    'displayField' => 'uf',
                                    'liveSearch' => true,
                                    'keyField' => 'id'
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
            var SPMaskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00)00000-0000' : '(00)0000-00009';
            },
            spOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                },
                placeholder: '(__) ______-_____'
            };

            $('.mask_phone').mask(SPMaskBehavior, spOptions);

            $('#cep').mask('00.000-000', {placeholder: '__.___-___'});
            
            if ($("#tipo_pessoa_id").val() == 1) {
                $("#cpf_cnpj").mask('000.000.000-00', {placeholder: '___.___.___-__'});
            } else {
               $("#cpf_cnpj").mask('00.000.000/0000-00', {placeholder: '__.___.___/____-__'}); 
            }

            $('#tipo_pessoa_id').on('changed.bs.select', function (e) {
                $("#cpf_cnpj").val('');
                if ($("#tipo_pessoa_id").val() == 1) {
                    $("#cpf_cnpj").mask('000.000.000-00', {placeholder: '___.___.___-__'});
                } else {
                    $("#cpf_cnpj").mask('00.000.000/0000-00', {placeholder: '__.___.___/____-__'}); 
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>