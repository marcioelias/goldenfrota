@extends('layouts.app')

@section('content')
    <div class="card">
        @component('components.form', [
            'title' => 'Nova Entrada de Combustível', 
            'routeUrl' => route('tanque_movimentacao.store'), 
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
                ])
                @endcomponent
                @component('components.form-group', [
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
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
    <script>
        $(document).ready(function() {
            var BuscarTanque = function() {
                var combustivel = {};

                combustivel.id = $('#combustivel_id').val();
                combustivel._token = $('input[name="_token"]').val();

                $.ajax({
                    url: '{{ route("tanques.json") }}',
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
@endsection