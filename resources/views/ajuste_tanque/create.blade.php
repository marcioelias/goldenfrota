@extends('layouts.app') 

@section('content')
    <div class="panel panel-default">
        @component('components.form', [
            'title' => 'Novo Ajuste de Tanque', 
            'routeUrl' => route('ajuste_tanque.store'), 
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
                            'type' => 'select',
                            'field' => 'tanque_id',
                            'label' => 'Tanque',
                            'required' => true,
                            'autofocus' => true,
                            'items' => $tanques,
                            'inputSize' => 8,
                            'displayField' => 'tanque',
                            'keyField' => 'id',
                            'defaultNone' => true
                        ],
                        [
                            'type' => 'number',
                            'field' => 'quantidade_informada',
                            'label' => 'Qtd Informada',
                            'required' => true,
                            'inputSize' => 4
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection