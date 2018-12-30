@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        @component('components.form', [
            'title' => 'Novo Combustível', 
            'routeUrl' => route('combustivel.store'), 
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
                            'field' => 'descricao',
                            'label' => 'Combustivel',
                            'required' => true,
                            'autofocus' => true
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
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'number',
                            'field' => 'valor',
                            'label' => 'Valor',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 4
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
    {{--  <script>
        jQuery(function($){
            $("#valor").mask('0.000', {reverse: true});
        });
    </script>  --}}
@endsection