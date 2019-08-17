@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Alterar Modelo de Bomba', 
            'routeUrl' => route('modelo_bomba.update', $modelo_bomba->id), 
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
                            'field' => 'modelo_bomba',
                            'label' => 'Modelo de Bomba',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => $modelo_bomba->modelo_bomba,
                            'inputSize' => 7
                        ],
                        [
                            'type' => 'text',
                            'field' => 'num_bicos',
                            'label' => 'Núm. Bicos',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => $modelo_bomba->num_bicos,
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $modelo_bomba->ativo,
                            'items' => Array('Não', 'Sim'),
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection