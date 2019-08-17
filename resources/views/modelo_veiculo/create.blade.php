@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Novo Modelo de Veículo', 
            'routeUrl' => route('modelo_veiculo.store'), 
            'method' => 'POST',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Salvar', 'icon' => 'check'],
                ['type' => 'button', 'label' => 'Cancelar', 'icon' => 'times']
                ]
            ])
            @section('formFields')
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'modelo_veiculo',
                            'label' => 'Modelo de Veículo',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 6
                        ],
                        [
                            'type' => 'select',
                            'field' => 'marca_veiculo_id',
                            'label' => 'Marca de Veículo',
                            'required' => true,
                            'items' => $marcaVeiculos,
                            'inputSize' => 6,
                            'displayField' => 'marca_veiculo',
                            'keyField' => 'id',
                            'liveSearch' => true,
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'number',
                            'field' => 'capacidade_tanque',
                            'label' => 'Capacidade do Tanque',
                            'required' => true,
                            'inputSize' => 6
                        ],
                        [
                            'type' => 'select',
                            'field' => 'tipo_controle_veiculo_id',
                            'label' => 'Tipo de Controle',
                            'required' => true,
                            'items' => $tipoControleVeiculos,
                            'inputSize' => 6,
                            'displayField' => 'tipo_controle_veiculo',
                            'keyField' => 'id',
                            'liveSearch' => true,
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection