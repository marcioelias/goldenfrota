@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Alterar Tanque', 
            'routeUrl' => route('tanque.update', $tanque->id), 
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
                            'field' => 'descricao_tanque',
                            'label' => 'Tanque',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => $tanque->descricao_tanque,
                            'inputSize' => 6
                        ],
                        [
                            'type' => 'select',
                            'field' => 'combustivel_id',
                            'label' => 'Combustível',
                            'required' => true,
                            'items' => $combustiveis,
                            'inputSize' => 5,
                            'displayField' => 'descricao',
                            'keyField' => 'id',
                            'indexSelected' => $tanque->combustivel_id,
                            'liveSearch' => true
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $tanque->ativo,
                            'items' => Array('Não', 'Sim'),
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'capacidade',
                            'label' => 'Capacidade',
                            'required' => true,
                            'inputSize' => 4,
                            'inputValue' => $tanque->capacidade
                        ],
                        [
                            'type' => 'text',
                            'field' => 'posicao',
                            'label' => 'Posição Atual',
                            'required' => true,
                            'inputSize' => 4,
                            'inputValue' => $tanque->posicao,
                            {{--  'disabled' => true  --}}
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection