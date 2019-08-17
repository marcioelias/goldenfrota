@extends('layouts.app')

@section('content')
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Novo Grupo de Produto', 
            'routeUrl' => route('grupo_produto.store'), 
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
                            'field' => 'grupo_produto',
                            'label' => 'Grupo de Produto',
                            'required' => true,
                            'autofocus' => true,
                            'inputValue' => isset($grupoProduto->grupo_produto) ? $grupoProduto->grupo_produto : ''
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection