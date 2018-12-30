@extends('layouts.app') 

@section('content')
    <div class="panel panel-default">
        @component('components.form', [
            'title' => 'Novo Estoque', 
            'routeUrl' => route('estoque.store'), 
            'method' => 'POST',
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
                            'field' => 'estoque',
                            'label' => 'Estoque',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 8
                        ],
                        [
                            'type' => 'select',
                            'field' => 'permite_estoque_negativo',
                            'label' => 'Permite Estoque Negativo',
                            'inputSize' => 3,
                            'items' => ['Não', 'Sim'],
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection