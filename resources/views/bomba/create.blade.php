@extends('layouts.app')

@section('content')
    <div class="card">
        @component('components.form', [
            'title' => 'Nova Bomba', 
            'routeUrl' => route('bomba.store'), 
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
                            'field' => 'descricao_bomba',
                            'label' => 'Bomba',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => isset($bomba->descricao_bomba) ? $bomba->descricao_bomba : '',
                            'inputSize' => 6
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'tipo_bomba_id',
                            'label' => 'Tipo de Bomba',
                            'required' => true,
                            'items' => $tipoBombas,
                            'inputSize' => 6,
                            'displayField' => 'tipo_bomba',
                            'keyField' => 'id',
                            'indexSelected' => isset($bomba->tipo_bomba_id) ? $bomba->tipo_bomba_id : ''
                        ],
                        [
                            'type' => 'select',
                            'field' => 'modelo_bomba_id',
                            'label' => 'Modelo de Bomba',
                            'required' => true,
                            'items' => $modeloBombas,
                            'inputSize' => 6,
                            'displayField' => 'modelo_bomba',
                            'keyField' => 'id',
                            'indexSelected' => isset($bomba->modelo_bomba_id) ? $bomba->modelo_bomba_id : ''
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection