@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Alterar Tipo de Bomba', 
            'routeUrl' => route('tipo_bomba.update', $tipo_bomba->id), 
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
                            'field' => 'tipo_bomba',
                            'label' => 'Tipo de Bomba',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => $tipo_bomba->tipo_bomba,
                            'inputSize' => 7
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $tipo_bomba->ativo,
                            'items' => Array('Não', 'Sim'),
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection