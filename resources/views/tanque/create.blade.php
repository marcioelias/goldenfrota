@extends('layouts.app')

@section('content')
    <div class="card">
        @component('components.form', [
            'title' => 'Novo Tanque', 
            'routeUrl' => route('tanque.store'), 
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
                            'field' => 'descricao_tanque',
                            'label' => 'Tanque',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => isset($tanque->descricao_tanque) ? $tanque->descricao_tanque : '',
                            'inputSize' => 6
                        ],
                        [
                            'type' => 'select',
                            'field' => 'combustivel_id',
                            'label' => 'Combustível',
                            'required' => true,
                            'items' => $combustiveis,
                            'inputSize' => 6,
                            'displayField' => 'descricao',
                            'keyField' => 'id',
                            'liveSearch' => true,
                            'indexSelected' => isset($tanque->combustivel_id) ? $tanque->combustivel_id : ''
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
                            'inputValue' => isset($tanque->capacidade) ? $tanque->capacidade : ''
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection