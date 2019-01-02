@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Nova Aferição', 
            'routeUrl' => route('afericao.store'), 
            'cancelRoute' => 'abastecimento.index',
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
                            'field' => 'abastecimento_id',
                            'label' => 'ID Abastecimento',
                            'readOnly' => true,
                            'inputValue' => $abastecimento->id,
                            'inputSize' => 2
                        ],
                        [
                            'type' => 'text',
                            'field' => 'bico',
                            'label' => 'Bico',
                            'inputSize' => 2,
                            'readOnly' => true,
                            'inputValue' => $abastecimento->bico->id
                        ],
                        [
                            'type' => 'text',
                            'field' => 'volume',
                            'label' => 'Litros',
                            'inputSize' => 2,
                            'readOnly' => true,
                            'inputValue' => $abastecimento->volume_abastecimento
                        ],
                        [
                            'type' => 'text',
                            'field' => 'encerrante_inicial',
                            'label' => 'Encerrante Inicial',
                            'inputSize' => 3,
                            'readOnly' => true,
                            'inputValue' => $abastecimento->encerrante_inicial
                        ],
                        [
                            'type' => 'text',
                            'field' => 'encerrante_final',
                            'label' => 'Encerrante Final',
                            'inputSize' => 3,
                            'readOnly' => true,
                            'inputValue' => $abastecimento->encerrante_final
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'tanque',
                            'label' => 'Tanque',
                            'inputSize' => 4,
                            'readOnly' => true,
                            'inputValue' => $abastecimento->bico->tanque->descricao_tanque
                        ],
                        [
                            'type' => 'text',
                            'field' => 'combustivel',
                            'label' => 'Combustível',
                            'inputSize' => 8,
                            'readOnly' => true,
                            'inputValue' => $abastecimento->bico->tanque->combustivel->descricao
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection