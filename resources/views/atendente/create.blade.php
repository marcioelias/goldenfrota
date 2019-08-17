@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Novo Atendente', 
            'routeUrl' => route('atendente.store'), 
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
                            'field' => 'nome_atendente',
                            'label' => 'Nome',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => isset($atendente->nome_atendente) ? $atendente->nome_atendente : '',
                            'inputSize' => 6
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'usuario_atendente',
                            'label' => 'Usuário',
                            'required' => true,
                            'inputValue' => isset($atendente->usuario_atendente) ? $atendente->usuario_atendente : '',
                            'inputSize' => 6
                        ],
                        [
                            'type' => 'text',
                            'field' => 'senha_atendente',
                            'label' => 'Senha',
                            'required' => true,
                            'inputValue' => isset($atendente->senha_atendente) ? $atendente->senha_atendente : '',
                            'inputSize' => 6
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection