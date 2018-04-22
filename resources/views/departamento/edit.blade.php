@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        @component('components.form', [
            'title' => 'Alterar Departamento', 
            'routeUrl' => route('departamento.update', $departamento->id), 
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
                            'type' => 'select',
                            'field' => 'cliente_id',
                            'label' => 'Cliente',
                            'required' => true,
                            'items' => $clientes,
                            'autofocus' => true,
                            'displayField' => 'nome_razao',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 11,
                            'indexSelected' => $departamento->cliente_id
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $departamento->ativo,
                            'items' => ['Não', 'Sim'],
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'departamento',
                            'label' => 'Departamento',
                            'required' => true,
                            'inputValue' => $departamento->departamento
                        ]
                    ]
                ])
                @endcomponent
            @endsection 
        @endcomponent
    </div>
@endsection