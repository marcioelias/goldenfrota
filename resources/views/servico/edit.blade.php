@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        @component('components.form', [
            'title' => 'Alterar Serviço', 
            'routeUrl' => route('servico.update', $servico->id), 
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
                            'type' => 'text',
                            'field' => 'servico',
                            'label' => 'Serviço',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 11,
                            'inputValue' => $servico->servico
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $servico->ativo,
                            'items' => Array('Não', 'Sim'),
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'grupo_servico_id',
                            'label' => 'Grupo de Serviço',
                            'required' => true,
                            'items' => $grupo_servicos,
                            'inputSize' => 8,
                            'displayField' => 'grupo_servico',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'defaultNone' => true,
                            'indexSelected' => $servico->grupo_servico_id
                        ],
                        [
                            'type' => 'number',
                            'field' => 'valor_servico',
                            'label' => 'Valor',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 4,
                            'inputValue' => $servico->valor_servico
                        ] 
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'textarea',
                            'field' => 'descricao',
                            'label' => 'Descrição',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => $servico->descricao
                        ],
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection