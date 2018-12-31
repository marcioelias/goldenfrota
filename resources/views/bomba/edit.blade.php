@extends('layouts.app')

@section('content')
    <div class="card">
        @component('components.form', [
            'title' => 'Alterar Bomba', 
            'routeUrl' => route('bomba.update', $bomba->id), 
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
                            'field' => 'descricao_bomba',
                            'label' => 'Bomba',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => $bomba->descricao_bomba,
                            'inputSize' => 6
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $bomba->ativo,
                            'items' => Array('Não', 'Sim'),
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
                            'indexSelected' => $bomba->tipo_bomba_id
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
                            'indexSelected' => $bomba->modelo_bomba_id
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection