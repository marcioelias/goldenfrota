@extends('layouts.app')

@section('content')
@if(old('fornecedores')) 
    {{--  {{ dd(old(str_replace('[]', '', 'fornecedores[]'))) }}  --}}
@endif
    <div class="card m-0 border-0">
        @component('components.form', [
            'title' => 'Novo Produto', 
            'routeUrl' => route('produto.store'), 
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
                            'field' => 'produto_descricao',
                            'label' => 'Descrição',
                            'required' => true,
                            'autofocus' => true,
                            'inputSize' => 6
                        ],
                        [
                            'type' => 'text',
                            'field' => 'produto_desc_red',
                            'label' => 'Descrição Reduzida',
                            'inputSize' => 2,
                            'maxLength' => 10
                        ],
                        [
                            'type' => 'select',
                            'field' => 'grupo_produto_id',
                            'label' => 'Grupo',
                            'required' => true,
                            'items' => $grupoProdutos,
                            'inputSize' => 4,
                            'displayField' => 'grupo_produto',
                            'keyField' => 'id',
                            'liveSearch' => true,
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'unidade_id',
                            'label' => 'Unidade',
                            'required' => true,
                            'items' => $unidades,
                            'inputSize' => 4,
                            'displayField' => 'unidade',
                            'keyField' => 'id',
                            'liveSearch' => true,
                        ],
                        [
                            'type' => 'number',
                            'field' => 'valor_custo',
                            'label' => 'Preço de Custo',
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'number',
                            'field' => 'valor_venda',
                            'label' => 'Preço de Venda',
                            'inputSize' => 4
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'select',
                            'field' => 'controla_vencimento',
                            'label' => 'Controla Vencimento',
                            'inputSize' => 4,
                            'items' => Array('Não', 'Sim'),
                        ],  
                        [
                            'type' => 'integer',
                            'field' => 'vencimento_dias',
                            'label' => 'Vencimento em Dias',
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'integer',
                            'field' => 'vencimento_km',
                            'label' => 'Vencimento em Km',
                            'inputSize' => 4
                        ]
                    ]
                ])
                @endcomponent
                @component('components.form-group', [
                    'inputs' => [
                        [
                            'type' => 'text',
                            'field' => 'numero_serie',
                            'label' => 'Número de Série',
                            'inputSize' => 6
                        ],
                        [
                            'type' => 'text',
                            'field' => 'codigo_barras',
                            'label' => 'Código de Barras',
                            'inputSize' => 6
                        ]
                    ]
                ])
                @endcomponent
                <div class="row">
                    <div class="col-md-4">
                        @component('components.input-checklist-group', [
                            'items' => $fornecedores,
                            'label' => 'nome_razao',
                            'field' => 'fornecedores[]',
                            'title' => 'Fornecedores',
                            'value' => 'id'
                        ])
                        @endcomponent
                    </div>
                    <div class="col-md-8" id="estoqueProdutoComponent">
                        {{--  @component('components.input-checklist-group', [
                            'items' => $estoques,
                            'label' => 'estoque',
                            'field' => 'estoques[]',
                            'title' => 'Estoques',
                            'value' => 'id'
                        ])
                        @endcomponent  --}}  
                        <estoque_produto :estoques-data="{{ json_encode($listaEstoques) }}" :old-data="{{ json_encode(old('estoques')) }}"></estoque_produto>                      
                    </div>
                </div>
            @endsection
        @endcomponent
    </div>
@push('bottom-scripts')
    <script>
        jQuery(function($){
            $("#valor").mask('0.00', {reverse: true});
        });
    </script>
    <script src="{{ mix('js/estoqueproduto.js') }}"></script>
@endpush
@endsection