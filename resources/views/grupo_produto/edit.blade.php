@extends('layouts.app')

@section('content')
    <div class="card">
        @component('components.form', [
            'title' => 'Alterar Grupo de Produto', 
            'routeUrl' => route('grupo_produto.update', $grupoProduto->id), 
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
                            'field' => 'grupo_produto',
                            'label' => 'Grupo de Produto',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => $grupoProduto->grupo_produto,
                            'inputSize' => 7
                        ],
                        [
                            'type' => 'select',
                            'field' => 'ativo',
                            'label' => 'Ativo',
                            'inputSize' => 1,
                            'indexSelected' => $grupoProduto->ativo,
                            'items' => Array('Não', 'Sim'),
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection