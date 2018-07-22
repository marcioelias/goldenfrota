@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        @component('components.form', [
            'title' => 'Movimentacao de Estoque - Produtos', 
            'routeUrl' => route('relatorio_movimentacao_estoque'), 
            'formTarget' => '_blank',
            'method' => 'POST',
            'formButtons' => [
                ['type' => 'submit', 'label' => 'Gerar Relatório', 'icon' => 'stats'],
                ]
            ])
            @section('formFields')
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'estoque_id',
                            'label' => 'Estoque',
                            'required' => true,
                            'items' => $estoques,
                            'autofocus' => true,
                            'displayField' => 'estoque',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 3
                        ],
                        [
                            'type' => 'select',
                            'field' => 'grupo_produto_id',
                            'label' => 'Grupo de Produto',
                            'items' => $grupo_produtos,
                            'displayField' => 'grupo_produto',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'inputSize' => 3
                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_inicial',
                            'label' => 'Data Inicial',
                            'inputSize' => 3,
                            'dateTimeFormat' => 'DD/MM/YYYY',
                            'picker_begin' => 'data_inicial',
                            'picker_end' => 'data_final',
                            'inputValue' => date('01/m/Y'),
                        ],
                        [
                            'type' => 'datetime',
                            'field' => 'data_final',
                            'label' => 'Data Final',
                            'inputSize' => 3,
                            'dateTimeFormat' => 'DD/MM/YYYY',
                            'picker_begin' => 'data_inicial',
                            'picker_end' => 'data_final',
                            'inputValue' => date('t/m/Y')
                        ],
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
@endsection