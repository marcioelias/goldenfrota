@extends('layouts.app')

@section('content')}
    <div class="card">
        @component('components.form', [
            'title' => 'Alterar Entrada de Combustível', 
            'routeUrl' => route('tanque_movimentacao.update', $movimentacao->id), 
            'method' => 'PUT',
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
                            'inputValue' => \DateTime::createFromFormat('Y-m-d', $movimentacao->data_movimentacao)->format('d/m/Y')
                        ],
                        [
                            'type' => 'text',
                            'field' => 'documento',
                            'label' => 'Documento',
                            'inputSize' => 4,
                            'inputValue' => $movimentacao->documento
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $movimentacao->ativo,
                            'items' => ['Não', 'Sim'],
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
                            'indexSelected' => $movimentacao->combustivel_id
                        ],
                        [
                            'type' => 'select',
                            'field' => 'tanque_id',
                            'label' => 'Tanque',
                            'items' => null,
                            'inputSize' => 4,
                            'displayField' => 'descricao_tanque',
                            'keyField' => 'id',
                            'liveSearch' => true
                        ],
                        [
                            'type' => 'text',
                            'field' => 'quantidade_combustivel',
                            'label' => 'Quantidade',
                            'inputSize' => 4,
                            'inputValue' => $movimentacao->quantidade_combustivel
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

                console.log(combustivel);
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
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }

            BuscarTanque();
            $('#combustivel_id').on('changed.bs.select', BuscarTanque);
            $('#combustivel_id').on('hide.bs.select', BuscarTanque);
        });
    </script>
@endsection