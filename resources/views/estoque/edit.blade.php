@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        @component('components.form', [
            'title' => 'Alterar Estoque', 
            'routeUrl' => route('estoque.update', $estoque->id), 
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
                            'field' => 'estoque',
                            'label' => 'Estoque',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => $estoque->estoque,
                            'inputSize' => 8
                        ],
                        [
                            'type' => 'select',
                            'field' => 'permite_estoque_negativo',
                            'label' => 'Permite Estoque Negativo',
                            'inputSize' => 3,
                            'indexSelected' => $estoque->permite_estoque_negativo,
                            'items' => ['Não', 'Sim'],
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $estoque->ativo,
                            'items' => ['Não', 'Sim'],
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection