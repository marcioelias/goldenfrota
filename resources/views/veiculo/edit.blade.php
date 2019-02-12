@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Alterar Veículo', 
            'routeUrl' => route('veiculo.update', $veiculo->id), 
            'method' => 'PUT',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Salvar', 'icon' => 'check'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'times']
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
                ])
                @endcomponent
                @component('components.form-group', [
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
                ])
                @endcomponent
                @component('components.form-group', [
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
                            'type' => 'number',
                            'field' => 'ano',
                            'label' => 'Ano',
                            'inputSize' => 2,
                            'inputValue' => $veiculo->ano
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
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
                            'type' => 'number',
                            'field' => 'hodometro',
                            'label' => 'Km',
                            'inputSize' => 3,
                            'inputValue' => $veiculo->hodometro
                        ],
                        [
                            'type' => 'number',
                            'field' => 'media_minima',
                            'label' => 'Média Mínima',
                            'inputSize' => 3,
                            'inputValue' => $veiculo->media_minima
                        ],
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection

@push('document-ready')
    $('#placa').mask('AAA-9999', {placeholder: '___-____'});
            
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

                $('#departamento_id').append('<option disabled selected value style="display:none"> Nada Selecionado </option>');

                $.each(data, function (i, item) {
                    $('#departamento_id').append($('<option>', { 
                        value: item.id,
                        text : item.departamento 
                    }));
                });
                
                @if(old('departamento_id'))
                $('#departamento_id').selectpicker('val', {{old('departamento_id')}});
                @else
                $('#departamento_id').selectpicker('val', {{$veiculo->departamento_id}});
                @endif

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
            url: '{{ route("modelo_veiculos.json") }}',
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

                @if(old('modelo_veiculo_id'))
                $('#modelo_veiculo_id').selectpicker('val', {{old('modelo_veiculo_id')}});
                @else
                $('#modelo_veiculo_id').selectpicker('val', {{$veiculo->modelo_veiculo_id}});
                @endif

                $('.selectpicker').selectpicker('refresh');
            }
        });
    }

    buscarDepartamentos();
    buscarModeloVeiculos();    
@endpush
