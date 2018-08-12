@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        @component('components.form', [
            'title' => 'Novo Abastecimento', 
            'routeUrl' => route('abastecimento.store'), 
            'method' => 'POST',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Salvar', 'icon' => 'ok'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'remove']
                ]
            ])
            @section('formFields')
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'datetime',
                            'field' => 'data_hora_abastecimento',
                            'label' => 'Data/Hora',
                            'required' => true,
                            'inputSize' => 4,
                            'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss',
                            'sideBySide' => true,
                            'inputValue' => date('d/m/Y H:i:s')
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
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'veiculo_id',
                            'label' => 'Veículo',
                            'required' => true,
                            'items' => null,
                            'disabled' => true,
                            'inputSize' => 8,
                            'displayField' => 'placa',
                            'liveSearch' => true,
                            'keyField' => 'id'
                        ],
                        [
                            'type' => 'number',
                            'field' => 'km_veiculo',
                            'label' => 'KM do Veículo',
                            'required' => true,
                            'inputSize' => 4                            
                        ],
                    ]
                ])
                @endcomponent
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>AUTOMAÇÃO</strong>
                    </div>
                    <div class="panel-body">
                        @component('components.form-group', [
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
                                ],
                                [
                                    'type' => 'number',
                                    'field' => 'encerrante_inicial',
                                    'label' => 'Encerrante Inicial',
                                    'required' => true,
                                    'inputSize' => 4,   
                                    'readOnly' => true                       
                                ],
                                [
                                    'type' => 'number',
                                    'field' => 'encerrante_final',
                                    'label' => 'Encerrante Final',
                                    'required' => true,
                                    'inputSize' => 4, 
                                    'readOnly' => true            
                                ]
                            ]
                        ])
                        @endcomponent
                    </div>
                </div>
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'combustivel_descricao',
                            'label' => 'Combustível',
                            'inputSize' => 6,
                            'readOnly' => true
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
                            'readOnly' => true,
                        ]
                    ]
                ])
                @endcomponent
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>OBSERVAÇÕES</strong>
                    </div>
                    <div class="panel-body">
                        @component('components.form-group', [
                            'inputs' => [
                                [
                                    'type' => 'textarea',
                                    'field' => 'obs_abastecimento',
                                    'label' => false,
                                ]
                            ]
                        ])
                        @endcomponent
                    </div>
                </div>
            @endsection
        @endcomponent
    </div>
    <script>
        $(document).ready(function() {
            //$('#valor_litro').mask('#.000', {{--  {reverse: true}  --}});
           {{--   $('#volume_abastecimento').mask('#00.00#', {reverse: true});
            $('#valor_abastecimento').mask('#00.00', {reverse: true});  --}}
            $('#km_veiculo').mask('#');

            function CalcValorAbastecimento() {
                //console.log('calculou abastecimento');
                var volume, valor_unitario = 0;
                volume = parseFloat($('#volume_abastecimento').val().replace(',', '.'));
                valor_unitario = parseFloat($('#valor_litro').val().replace(',', '.'));
                if ((volume > 0) && (valor_unitario > 0)) {
                    $('#valor_abastecimento').val(volume * valor_unitario);
                } else {
                    $('#valor_abastecimento').val(0);
                }
            }

            function CalcularEncerranteFinal() {
                var encIni, encFin, qtdAbast;
                encIni = parseFloat($('#encerrante_inicial').val().replace(',', '.'));
                qtdAbast = parseFloat($('#volume_abastecimento').val().replace(',', '.'));

                if (qtdAbast > 0) {
                    //console.log('qtdAbast: '+qtdAbast);
                    //console.log('encIni: '+encIni);
                    $('#encerrante_final').val(encIni + qtdAbast);
                }

            }

            $('#volume_abastecimento').keyup(CalcValorAbastecimento, CalcularEncerranteFinal);
            $('#volume_abastecimento').blur(CalcValorAbastecimento, CalcularEncerranteFinal);

            $('#valor_litro').keyup(CalcValorAbastecimento);
            $('#valor_litro').blur(CalcValorAbastecimento);

            var buscarDadosBico = function() {  
                var bico = {};

                bico.id = $('#bico_id').val();
                bico._token = $('input[name="_token"]').val();

                $.ajax({
                    url: '{{ route("bico.json") }}',
                    type: 'POST',
                    data: bico,
                    dataType: 'JSON',
                    cache: false,
                    success: function (data) {
                        //console.log(data);
                        $("#encerrante_inicial").val(data.encerrante);
                        $("#combustivel_descricao").val(data.tanque.combustivel.descricao);
                        $("#valor_litro").val(data.tanque.combustivel.valor);
                        $("#volume_abastecimento").focus();


                        $('.selectpicker').selectpicker('refresh');
                    },
                    error: function (data) {
                        //console.log(data);
                    }
                });
            }

            var buscarVeiculos = function() {
                var cliente = {};

                cliente.id = $('#cliente_id').val();
                cliente._token = $('input[name="_token"]').val();

                //console.log(cliente);
                $.ajax({
                    url: '{{ route("veiculos.json") }}',
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
                        
                        @if(old('modelo_veiculo_id'))
                        $('#modelo_veiculo_id').selectpicker('val', {{old('modelo_veiculo_id')}});
                        @endif

                        $('.selectpicker').selectpicker('refresh');
                    },
                    error: function (data) {
                        //console.log(data);
                    }
                });
            }

            $('#cliente_id').on('changed.bs.select', buscarVeiculos);
            $('#bico_id').on('changed.bs.select', buscarDadosBico);

            if ($('#cliente_id').val()) {
                buscarVeiculos();
            }
        });
    </script>
@endsection