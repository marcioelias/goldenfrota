@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Alterar Modelo de Veículo', 
            'routeUrl' => route('modelo_veiculo.update', $modeloVeiculo->id), 
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
                            'type' => 'text',
                            'field' => 'modelo_veiculo',
                            'label' => 'Modelo de Veículo',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => $modeloVeiculo->modelo_veiculo,
                            'inputSize' => 6
                        ],
                        [
                            'type' => 'select',
                            'field' => 'marca_veiculo_id',
                            'label' => 'Marca de Veículo',
                            'required' => true,
                            'items' => $marcaVeiculos,
                            'inputSize' => 5,
                            'displayField' => 'marca_veiculo',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'indexSelected' => $modeloVeiculo->marca_veiculo_id
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $modeloVeiculo->ativo,
                            'items' => Array('Não', 'Sim'),
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
                            'inputSize' => 6,
                            'inputValue' => $modeloVeiculo->capacidade_tanque
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
                            'indexSelected' => $modeloVeiculo->tipo_controle_veiculo_id
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection