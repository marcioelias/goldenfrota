@extends('layouts.app')

@section('content')
    <div class="card">
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
                        [
                            'type' => 'btn-group',
                            'field' => 'tipo_relatorio',
                            'label' => 'Tipo de Relatório',
                            'radioButtons' => [
                                [
                                    'label' => 'Sintético',
                                    'value' => 1
                                ],
                                [
                                    'label' => 'Analítico',
                                    'value' => 2
                                ],
                            ],
                            'inputSize' => 3,
                            'defaultValue' => 1
                        ],
                        [
                            'type' => 'btn-group',
                            'field' => 'tipo_movimentacao',
                            'label' => 'Tipo de Movimentação',
                            'radioButtons' => [
                                [
                                    'label' => 'Entradas',
                                    'value' => 1
                                ],
                                [
                                    'label' => 'Saídas',
                                    'value' => 2
                                ],
                                [
                                    'label' => 'Todos',
                                    'value' => 3
                                ],
                            ],
                            'inputSize' => 3,
                            'defaultValue' => 3,
                        ]
                    ]
                ])
                @endcomponent
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
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'select',
                            'field' => 'grupo_produto_id',
                            'label' => 'Grupo de Produto',
                            'items' => null,
                            'displayField' => 'grupo_produto',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'disabled' => true,
                            'defaultNone' => true,
                            'inputSize' => 4
                        ],
                        [
                            'type' => 'select',
                            'field' => 'produto_id',
                            'label' => 'Produto',
                            'items' => null,
                            'displayField' => 'produto_descricao',
                            'liveSearch' => true,
                            'keyField' => 'id',
                            'defaultNone' => true,
                            'disabled' => true,
                            'inputSize' => 4
                        ]
                    ]
                ])
                @endcomponent
            @endsection
        @endcomponent
    </div>
    <script>
        $(document).ready(function() {
            var clearSelect = function (selectComponentId) {
                $(selectComponentId)
                    .attr('disabled', 'disabled')
                    .find('option')
                    .remove();
                    $(selectComponentId).selectpicker('refresh');
            }

            var buscarGrupoProdutos = function() {
                var estoque = {};

                if(!$('#estoque_id').val()) {
                    clearSelect('#grupo_produto_id');
                    clearSelect('#produto_id');
                } else {     
                    estoque.id = $('#estoque_id').val();
                    estoque._token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ route("grupo_produto.json") }}',
                        type: 'POST',
                        data: estoque,
                        dataType: 'JSON',
                        cache: false,
                        success: function (data) {
                            $("#grupo_produto_id")
                                .removeAttr('disabled')
                                .find('option')
                                .remove(); 
                            
                            $('#grupo_produto_id').append($('<option>', {
                                value: '',
                                text: 'Nada Selecionado'
                            }));

                            $.each(data, function (i, item) {
                                $('#grupo_produto_id').append($('<option>', { 
                                    value: item.id,
                                    text : item.grupo_produto
                                }));
                            });
                            
                            @if(old('grupo_produto_id'))
                            $('#grupo_produto_id').selectpicker('val', {{old('grupo_produto_id')}});
                            @endif

                            $('.selectpicker').selectpicker('refresh');
                        },
                        error: function (data) {
                        }
                    });
                }
            }

            var buscarProdutos = function() {
                var grupo_produto = {};

                if(!$('#grupo_produto_id').val()) {
                    clearSelect('#produto_id');
                } else {              
                    grupo_produto.id = $('#grupo_produto_id').val();
                    grupo_produto._token = $('input[name="_token"]').val();

                    $.ajax({
                        url: '{{ route("produtos_pelo_grupo.json") }}',
                        type: 'POST',
                        data: grupo_produto,
                        dataType: 'JSON',
                        cache: false,
                        success: function (data) {
                            $("#produto_id")
                                .removeAttr('disabled')
                                .find('option')
                                .remove(); 

                            $('#produto_id').append($('<option>', {
                                value: '',
                                text: 'Nada Selecionado'
                            }));

                            $.each(data, function (i, item) {
                                $('#produto_id').append($('<option>', { 
                                    value: item.id,
                                    text : item.produto_descricao
                                }));
                            });
                            
                            @if(old('produto_id'))
                            $('#produto_id').selectpicker('val', {{old('produto_id')}});
                            @endif

                            $('.selectpicker').selectpicker('refresh');
                        },
                        error: function (data) {
                        }
                    });
                }
            }
            
            $('#estoque_id').on('changed.bs.select', buscarGrupoProdutos);
            $('#grupo_produto_id').on('changed.bs.select', buscarProdutos);

            if ($('#estoque_id').val()) {
                buscarGrupoProdutos();
            }

            if ($('#grupo_produto_id').val()) {
                buscarProdutos();
            }
        });
    </script>
@endsection