@extends('layouts.app')

@section('content')
@php
    if(count($errors) > 0) {
        //dd($errors);
    }
@endphp
<div id="saida_estoque_produtos">
    <div class="panel panel-default">
        @component('components.form', [
            'title' => 'Nova Saída do Estoque', 
            'routeUrl' => route('saida_estoque.store'), 
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
                            'displayField' => 'nome_razao',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'autofocus' => true,
                            'inputSize' => 5,
                            'defaultNone' => true,
                        ],
                        [
                            'type' => 'select',
                            'field' => 'departamento_id',
                            'label' => 'Departamento',
                            'items' => null,
                            'displayField' => 'departamento',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_saida',
                            'label' => 'Data Saída',
                            'required' => true,
                            'inputSize' => 3,
                            'inputValue' => date('d/m/Y H:i:s')
                        ],
                    ]
                ])
                @endcomponent
                {{--  @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'estoque_id',
                            'label' => 'Estoques',
                            'required' => true,
                            'items' => $estoques,
                            'displayField' => 'estoque',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'inputSize' => 6,
                            'defaultNone' => true,
                            'vModel' => 'estoqueId'
                        ],
                    ]
                ])
                @endcomponent  --}}
                <div class="{{ $errors->has('items') ? ' has-error' : '' }}">
                    <saida_estoque v-bind:estoques="{{ json_encode($estoques) }}" :estoque-error="{{ $errors->has('estoque_id') ? json_encode(['msg' => $errors->first('estoque_id')]) : 'null' }}" :old-estoque-id="{{ json_encode(['estoque_id' => old('estoque_id')]) }}" {{--  :produtos-data="{{ json_encode($produtos) }}"  --}} :old-data="{{ json_encode(old('items')) }}"></saida_estoque>
                    @if ($errors->has('items'))
                        <span class="help-block">
                            <strong>{{ $errors->first('items') }}</strong>
                        </span>
                    @endif
                </div>
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'textarea',
                            'field' => 'obs',
                            'label' => 'Observações',
                        ]
                    ]
                ])
                @endcomponent

               {{--   {{ dd($errors) }}  --}}
            @endsection
        @endcomponent
    </div>
</div>
@endsection
@push('bottom-scripts')
    <script src="{{ asset('js/saidaestoque.js') }}"></script>
    <script>
        $(document).ready(function() {
            var buscarDepartamentos = function() {
                var departamento = {};

                departamento.id = $('#cliente_id').val();
                departamento._token = $('input[name="_token"]').val();

                console.log(departamento);
                $.ajax({
                    url: '{{ route("departamentos.json") }}',
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


                        $.each(data, function (i, item) {
                            $('#departamento_id').append($('<option>', { 
                                value: item.id,
                                text : item.departamento 
                            }));
                        });
                        
                        @if(old('departamento_id'))
                        $('#departamento_id').selectpicker('val', {{old('departamento_id')}});
                        @endif

                        $('.selectpicker').selectpicker('refresh');
                    }
                });
            }

            
 
            $('#cliente_id').on('changed.bs.select', buscarDepartamentos);
            
            if ($('#cliente_id').val()) {
                buscarDepartamentos();
            }

        });
    </script>
@endpush