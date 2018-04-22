@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        @component('components.form', [
            'title' => 'Alterar Combustível', 
            'routeUrl' => route('combustivel.update', $combustivel->id), 
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
                            'field' => 'descricao',
                            'label' => 'Combustivel',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => $combustivel->descricao,
                            'inputSize' => 11
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $combustivel->ativo,
                            'items' => Array('Não', 'Sim'),
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'descricao_reduzida',
                            'label' => 'Desc. Reduzida',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 4,
                            'inputValue' => $combustivel->descricao_reduzida
                        ],
                        [
                            'type' => 'text',
                            'field' => 'valor',
                            'label' => 'Valor',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 4,
                            'inputValue' => $combustivel->valor
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
    <script>
        jQuery(function($){
            $("#valor").mask('0.000', {reverse: true});
        });
    </script>
@endsection