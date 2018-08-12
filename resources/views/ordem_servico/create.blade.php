@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        @component('components.form', [
            'title' => 'Nova Ordem de Serviço', 
            'routeUrl' => route('ordem_servico.store'), 
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
                            'type' => 'select',
                            'field' => 'cliente_id',
                            'label' => 'Cliente',
                            'required' => true,
                            'items' => $clientes,
                            'inputSize' => 6,
                            'displayField' => 'nome_razao',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'defaultNone' => true
                        ],
                        [
                            'type' => 'select',
                            'field' => 'veiculo_id',
                            'label' => 'Veiculo',
                            'required' => true,
                            'items' => null,
                            'inputSize' => 3,
                            'displayField' => 'placa',
                            'keyField' => 'id',
                            'liveSearch' => true,
                        ],
                        [
                            'type' => 'number',
                            'field' => 'km_veiculo',
                            'label' => 'KM Atual',
                            'required' => true,
                            'inputSize' => 2
                        ],
                        [
                            'type' => 'select',
                            'field' => 'fechada',
                            'label' => 'Fechada',
                            'inputSize' => 1,
                            'items' => Array('Não', 'Sim'),
                        ]
                    ]
                ])
                @endcomponent
                <div id="ordem_servico">
                    <ordem-servico 
                        :servicos-data="{{ json_encode($servicos) }}" 
                        :old-servicos-data="{{ json_encode(old('servicos')) }}"
                        v-bind:estoques="{{ json_encode($estoques) }}" 
                        :old-estoque-id="{{ json_encode(['estoque_id' => old('estoque_id')]) }}"
                        :old-produtos-data="{{ json_encode(old('items')) }}">
                    </ordem-servico>
                </div>
                
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'textarea',
                            'field' => 'obs',
                            'label' => 'Observações'
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@push('bottom-scripts')
    <script src="{{ asset('js/os.js') }}"></script>

    <script>
        $(document).ready(function() {
            var buscarVeiculos = function() {
                var cliente = {};

                cliente.id = $('#cliente_id').val();
                cliente._token = $('input[name="_token"]').val();

                $.ajax({
                    url: '{{ route("veiculos.json") }}',
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
                                text : item.placa 
                            }));
                        });

                        @if(old('veiculo_id'))
                        $('#veiculo_id').selectpicker('val', {{old('veiculo_id')}});
                        @endif

                        $('.selectpicker').selectpicker('refresh');
                    }
                });
            }
            $('#cliente_id').on('changed.bs.select', buscarVeiculos);
            
            if ($('#cliente_id').val()) {
                buscarVeiculos();
            }
        });
    </script>
@endpush
@endsection